<?php
namespace Modules\MLM\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class MlmSettingModel extends Model
{
    use HasFactory;
    protected $table = 'mlm_level_settings';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fieldSearchAccepted = ['email', 'phone', 'fullname'];
    protected $crudNotAccepted = ['_token','user_id','redirect'];
    protected $fillable = ['name','key','commission','commission_type','commission_group','mlm_level_id','mlm_indirect_level_id', 'created_at', 'updated_at'];
    public function listItems($params = "", $options = "")
    {
        $result = null;
        $query = $this->select('id','name','key','commission','commission_type','commission_group','mlm_level_id','mlm_indirect_level_id', 'created_at', 'updated_at');
        if ($options['task'] == 'list') {
            if(isset($params['is_trash']) && $params['is_trash'] == '1') {
                $query = $query->whereNotNull('deleted_at');
            }
            else {
                $query = $query->whereNull('deleted_at');
            }
         
            if(isset($params['level_id'])) {
                $query = $query->where('mlm_level_id',$params['level_id']);
            }
            if(isset($params['start']) && isset($params['length'])) {
                if($params['start'] == 0) {
                    $result = $query->orderBy('id', 'desc')->get();
                }
                else {
                    $result = $query->orderBy('id', 'desc')->skip($params['start'])->take($params['length'])->get();
                }
            }
            else {
                $result = $query->orderBy('id', 'desc')->get();
            }
        }
        if ($options['task'] == 'search') {
            if(isset($params['is_trash']) && $params['is_trash'] == '1') {
                $query = $query->whereNotNull('deleted_at');
            }
            else {
                $query = $query->whereNull('deleted_at');
            }
            if(isset($params['mlm_type_id'])) {
                $query = $query->where('mlm_type_id',$params['mlm_type_id']);
            }
            $result = $query->where('name', 'LIKE', "%{$params['title']}%")
            ->orderBy('id', 'desc')->get();
        }
        return $result;
    }
    public function getItem($params = [], $options = [])
    {
        $query = $this->select('id','name','key','commission','commission_type','commission_group','mlm_level_id','mlm_indirect_level_id', 'created_at', 'updated_at');
        if ($options['task'] == 'id') {
            $result = $query->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'slug') {
            $result = $query->where('slug', $params['slug'])->first();
        }
        if ($options['task'] == 'mlm_level_id') {
            $result = $query->whereNull('deleted_at')->where('mlm_level_id', $params['mlm_level_id'])->first();
        }
        return $result;
    }
    public function saveItem($params = [], $option = [])
    {
        if ($option['task'] == 'add-item') {
            $paramsInsert = array_diff_key($params, array_flip($this->crudNotAccepted));
            $result = self::insert($paramsInsert);
            return $result;
        }
        if ($option['task'] == 'edit-item') {
            $paramsUpdate = array_diff_key($params, array_flip($this->crudNotAccepted));
            self::where('id', $params['id'])->update($paramsUpdate);
        }
    }
    public function deleteItem($params = "", $option = "")
    {
        if ($option['task'] == 'delete') {
            $this->where('id', $params['id'])->delete();
        }
    }
    public function levels()
    {
        return $this->hasMany(MlmLevelModel::class, 'mlm_level_id', 'id');
    }
}
