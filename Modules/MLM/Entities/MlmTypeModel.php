<?php
namespace Modules\MLM\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class MlmTypeModel extends Model
{
    use HasFactory;
    protected $table = 'mlm_types';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fieldSearchAccepted = ['email', 'phone', 'fullname'];
    protected $crudNotAccepted = ['_token','user_id'];
    protected $fillable = ['name','class', 'created_at', 'updated_at','slug'];
    public function listItems($params = "", $options = "")
    {
        $result = null;
        $query = $this->select('id','name','class', 'created_at', 'updated_at','slug');
        if ($options['task'] == 'list') {
            $query = $query->whereNull('deleted_at');
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
            $result = $query->where('email', 'LIKE', "%{$params['title']}%")
            ->orWhere('name', 'LIKE', "%{$params['title']}%")
            ->orderBy('id', 'desc')->get();
        }
        return $result;
    }
    public function getItem($params = [], $options = [])
    {
        $query = $this->select('id', 'name','class', 'created_at', 'updated_at','slug');
        if ($options['task'] == 'id') {
            $result = $query->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'slug') {
            $result = $query->where('slug', $params['slug'])->first();
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
        return $this->hasMany(MlmLevelModel::class, 'mlm_type_id', 'id');
    }
}
