<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class LeadModel extends Model
{
    use HasFactory;
    protected $table = 'leads';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fieldSearchAccepted = ['email', 'mobile', 'first_name', 'middle_name', 'last_name'];
    protected $crudNotAccepted = ['_token', 'user_id', 'sponsor_id'];
    protected $fillable = ['first_name','middle_name','last_name','email','mobile','address','value_of_home','mortgage_balance','birthdate_of_youngest_person','marital_status','status','created_at','updated_at','ss_incom_annually'];
    // protected static function newFactory()
    // {
    //     return \Modules\User\Database\factories\UserModelFactory::new();
    // }
    public function listItems($params = "", $options = "")
    {
        $result = null;
        $query = $this->select('id','first_name','middle_name','last_name','email','mobile','address','value_of_home','mortgage_balance','birthdate_of_youngest_person','marital_status','ss_incom_annually','status','created_at','updated_at');
        if ($options['task'] == 'all') {
            if (isset($params['not_id'])) {
                $query = $query->where('id', '!=', $params['not_id']);
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
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('middle_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%");
            $result = $query->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        }
        return $result;
    }
    public function getItem($params = [], $options = [])
    {
        $query = $this->select('id','first_name','middle_name','last_name','email','mobile','address','value_of_home','mortgage_balance','birthdate_of_youngest_person','marital_status','ss_incom_annually','status','created_at','updated_at');
        if ($options['task'] == 'id') {
            $result = $query->where('id', $params['user_id'])->first();
        }
        if ($options['task'] == 'code') {
            $result = $query->where('code', $params['code'])->first();
        }
        return $result;
    }
    public function saveItem($params = [], $option = [])
    {
        if ($option['task'] == 'add-item') {
            $paramsInsert = array_diff_key($params, array_flip($this->crudNotAccepted));
            $result =    self::create($paramsInsert);
            $idInsert =  $result->id;
            return $idInsert;
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
}
