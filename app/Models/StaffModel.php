<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;
class StaffModel extends Model
{
    use HasFactory;
    protected $table = 'staffs';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fieldSearchAccepted = ['email', 'phone', 'fullname'];
    protected $crudNotAccepted = ['_token','user_id','sponsor_id'];
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'mobile', 'email', 'username', 'password', 'status','token','thumbnail','deleted_at', 'created_at','updated_at'];
    // protected static function newFactory()
    // {
    //     return \Modules\User\Database\factories\UserModelFactory::new();
    // }
    public function listItems($params = "", $options = "")
    {
        $result = null;
        $query = $this->select('id', 'first_name', 'middle_name', 'last_name', 'mobile', 'email', 'username', 'password', 'status','token','thumbnail','deleted_at', 'created_at','updated_at');
        if ($options['task'] == 'list') {
            if(isset($params['is_trash']) && $params['is_trash'] == '1') {
                $query = $query->whereNotNull('deleted_at');
            }
            else {
                $query = $query->whereNull('deleted_at');
            }
            if(isset($params['type'])) {
                $query = $query->where('type',$params['type']);
            }
            if(isset($params['not_id'])) {
                $query = $query->where('id','!=',$params['not_id']);
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
            $result = $query->where('email', 'LIKE', "%{$params['title']}%")
            ->orWhere('phone', 'LIKE', "%{$params['title']}%")
            ->orWhere('first_name', 'LIKE', "%{$params['title']}%")
            ->orWhere('last_name', 'LIKE', "%{$params['title']}%")
            ->orderBy('id', 'desc')->get();
        }
        return $result;
    }
    public function getItem($params = [], $options = [])
    {
        $query = $this->select('id','first_name', 'middle_name', 'last_name', 'mobile', 'email', 'username', 'password', 'status','token','thumbnail','deleted_at', 'created_at','updated_at');
        if ($options['task'] == 'login') {
            $result = $query->where('username', $params['username'])->where('password', md5($params['password']))->first();
        }
        if ($options['task'] == 'id') {
            $result = $query->where('id', $params['user_id'])->first();
        }
        if ($options['task'] == 'code') {
            $result = $query->where('code', $params['code'])->where('status','active')->first();
        }
        if ($options['task'] == 'email') {
            $result = $query->where('email', $params['email'])->first();
        }
        if ($options['task'] == 'mobile') {
            $result = $query->where('mobile', $params['mobile'])->first();
        }
        if ($options['task'] == 'username') {
            $result = $query->where('username', $params['username'])->first();
        }
        if ($options['task'] == 'token') {
            $result = $query->where('token', $params['token'])->first();
        }
        if ($options['task'] == 'verify_code') {
            $result = $query->where('verify_code', $params['verify_code'])->first();
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
}
