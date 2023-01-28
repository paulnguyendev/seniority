<?php
namespace Modules\User\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;
class UserModel extends Model
{
    use NodeTrait;
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fieldSearchAccepted = ['email', 'phone', 'fullname'];
    protected $crudNotAccepted = ['_token','user_id'];
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'phone', 'email', 'username', 'password', 'type', 'birthday', 'gender', 'thumbnail', 'address', 'token', 'code', 'bank_info', 'qrcode', '_lft', '_rgt', 'status', 'created_at', 'updated_at','email_verified_at','is_suppend','deleted_at'];
    // protected static function newFactory()
    // {
    //     return \Modules\User\Database\factories\UserModelFactory::new();
    // }
    public function listItems($params = "", $options = "")
    {
        $result = null;
        $query = $this->select('id', 'first_name', 'middle_name', 'last_name', 'phone', 'email', 'username', 'type', 'birthday', 'gender', 'thumbnail', 'address', 'token', 'code', 'qrcode', 'status', 'created_at', 'updated_at','email_verified_at','is_suppend','deleted_at');
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
            ->orWhere('phone', 'LIKE', "%{$params['title']}%")
            ->orWhere('first_name', 'LIKE', "%{$params['title']}%")
            ->orWhere('last_name', 'LIKE', "%{$params['title']}%")
            ->orderBy('id', 'desc')->get();
        }
        return $result;
    }
    public function getItem($params = [], $options = [])
    {
        $query = $this->select('id', 'first_name', 'middle_name', 'last_name', 'phone', 'email', 'username', 'password', 'type', 'birthday', 'gender', 'thumbnail', 'address', 'token', 'code', 'bank_info', 'qrcode', '_lft', '_rgt', 'status', 'created_at', 'updated_at','email_verified_at','is_suppend');
        if ($options['task'] == 'login') {
            $result = $query->where('username', $params['username'])->where('password', md5($params['password']))->first();
        }
        if ($options['task'] == 'id') {
            $result = $query->where('id', $params['user_id'])->first();
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
