<?php
namespace Modules\LevelLicenced\Entities;

use App\Models\AgentLicenseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class LevelLicencedModel extends Model
{
    use HasFactory;
    protected $table = 'license_levels';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fieldSearchAccepted = ['email', 'mobile', 'first_name', 'middle_name', 'last_name', 'code'];
    protected $crudNotAccepted = ['_token', 'user_id', 'sponsor_id'];
    protected $fillable = ['name','personal_payout','team_overrides','created_at','updated_at','is_break','is_default','sort','slug'];
    // protected static function newFactory()
    // {
    //     return \Modules\User\Database\factories\UserModelFactory::new();
    // }
    public function listItems($params = "", $options = "")
    {
        $result = null;
        $query = $this->select('id', 'name','personal_payout','team_overrides','created_at','updated_at','is_break','is_default','sort','slug');
        if ($options['task'] == 'all') {
            if (isset($params['not_id'])) {
                $query = $query->where('id', '!=', $params['not_id']);
            }
            if (isset($params['is_trash']) && $params['is_trash'] == '1') {
                $query = $query->whereNotNull('deleted_at');
            } else {
                $query = $query->whereNull('deleted_at');
            }
            $result = $query->orderBy('id', 'desc')->get();
        }
        if ($options['task'] == 'list') {
            if (isset($params['is_trash']) && $params['is_trash'] == '1') {
                $query = $query->whereNotNull('deleted_at');
            } else {
                $query = $query->whereNull('deleted_at');
            }
            if (isset($params['not_id'])) {
                $query = $query->where('id', '!=', $params['not_id']);
            }
            if (isset($params['is_break'])) {
                $query = $query->where('is_break', $params['is_break']);
            }
            if(isset($params['status'])) {
                if($params['status']) {
                    $query = $query->where('status', $params['status']);
                }
            }
            if(isset($params['parent_id'])) {
                if($params['parent_id']) {
                    $query = $query->where('parent_id', $params['parent_id']);
                }
            }
            if (isset($params['start']) && isset($params['length'])) {
                if ($params['start'] == 0) {
                    $result = $query->orderBy('id', 'desc')->get();
                } else {
                    $result = $query->orderBy('id', 'desc')->skip($params['start'])->take($params['length'])->get();
                }
            } else {
                $result = $query->orderBy('id', 'desc')->get();
            }
        }
        if ($options['task'] == 'search') {
            $search = $params['title'] ?? "";
            $query = $query->where('email', 'LIKE', "%{$search}%")
                ->orWhere('code', 'LIKE', "%{$search}%")
                ->orWhere('mobile', 'LIKE', "%{$search}%")
                ->orWhere('username', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('middle_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%");
            $result = $query->whereNull('deleted_at')->where('is_root', '0')->orderBy('id', 'desc')->get();
        }
        return $result;
    }
    public function getItem($params = [], $options = [])
    {
        $query = $this->select('id', 'name','personal_payout','team_overrides','created_at','updated_at','is_break','is_default','sort','slug');
        if ($options['task'] == 'id') {
            $result = $query->where('id', $params['user_id'])->first();
        }
        if ($options['task'] == 'is_default') {
            $result = $query->where('is_default',1)->first();
        }
        if ($options['task'] == 'slug') {
            $result = $query->where('slug',$params['slug'])->first();
        }
        return $result;
    }
    public function saveItem($params = [], $option = [])
    {
        if ($option['task'] == 'add-item') {
            $paramsInsert = array_diff_key($params, array_flip($this->crudNotAccepted));
            $parent = self::find($params['parent_id']);
            $result =    self::create($paramsInsert, $parent);
            return $result;
        }
        if ($option['task'] == 'edit-item') {
            $node = self::find($params['id']);
            $paramsUpdate = array_diff_key($params, array_flip($this->crudNotAccepted));
            $node->update($paramsUpdate);
        }
    }
    public function deleteItem($params = "", $option = "")
    {
        if ($option['task'] == 'delete') {
            $this->where('id', $params['id'])->delete();
        }
    }
    public function conditionLevel()
    {
        return $this->hasMany(ConditionLicenseLevelModel::class, 'level_id', 'id');
    }
    public function ambassadors()
    {
        return $this->hasMany(AgentLicenseModel::class, 'level_id', 'id');
    }
}
