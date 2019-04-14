<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class EarningSettingModel extends Model {

  protected $table = "earningsettings";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  
  public function user(){
      return $this->belongsTo(UserModel::class);
  }

  /**
   * 
   * @param type $id
   * @return response
   * @author Phong Le <pt.hongphong@gmail.com>
   * get referred1 and referred1 to calculate remaining percent of earning setting (100%-(referred1+referred2))
   * u is current user, u will join with earningsettings e
   * u1 is parent of u, u1 will join with earningsettings e1
   * u2 is parent of u1, u2 will join with earningsettings e2
   * because 1 studio has many model and 1 admin has many studio then value will return to max one to compare
   * 
   * 
   */
  public static function earningDetail($id = null) {
    if ($id) {
      return EarningSettingModel::select('earningsettings.*', 'u.username', DB::raw("case when u.role = 'model' then (
select MAX(e1.referredMember) 
from earningsettings e1
 where e1.userId=u.parentId
 )
when u.role='studio' then (
select MAX(e1.referredMember) 
from earningsettings e1 
where e1.userId=u.parentId
) 
when u.role='admin' then (
select MAX(e1.referredMember) 
from users u1
join earningsettings e1 on e1.userId=u1.id
where u1.parentId=u.id
)
end AS referred1"), DB::raw("case when u.role = 'model' then (
select MAX(e2.referredMember) 
from users u2 
join earningsettings e2 on e2.userId=u2.parentId
where u2.id=u.parentId
) 
when u.role='studio' then (
select MAX(e2.referredMember)
 from users u2 
join earningsettings e2 on e2.userId=u2.id
where u2.parentId=u.id
)
when u.role='admin' then (
select MAX(e2.referredMember) 
from users u2 
join users u3 on u3.parentId=u2.id 
join earningsettings e2 on e2.userId=u3.id
 where u2.parentId=u.id
)
end AS referred2"), DB::raw("case when u.role = 'model' then (
select MAX(e1.performerSiteMember) 
from earningsettings e1
 where e1.userId=u.parentId
 )
when u.role='studio' then (
select MAX(e1.performerSiteMember) 
from earningsettings e1 
where e1.userId=u.parentId
) 
when u.role='admin' then (
select MAX(e1.performerSiteMember) 
from users u1
join earningsettings e1 on e1.userId=u1.id
where u1.parentId=u.id
)
end AS performer1"), DB::raw("case when u.role = 'model' then (
select MAX(e2.performerSiteMember) 
from users u2 
join earningsettings e2 on e2.userId=u2.parentId
where u2.id=u.parentId
) 
when u.role='studio' then (
select MAX(e2.performerSiteMember)
 from users u2 
join earningsettings e2 on e2.userId=u2.id
where u2.parentId=u.id
)
when u.role='admin' then (
select MAX(e2.performerSiteMember) 
from users u2 
join users u3 on u3.parentId=u2.id 
join earningsettings e2 on e2.userId=u3.id
 where u2.parentId=u.id
)
end AS performer2"), DB::raw("case when u.role = 'model' then (
select MAX(e1.otherMember) 
from earningsettings e1
 where e1.userId=u.parentId
 )
when u.role='studio' then (
select MAX(e1.otherMember) 
from earningsettings e1 
where e1.userId=u.parentId
) 
when u.role='admin' then (
select MAX(e1.otherMember) 
from users u1
join earningsettings e1 on e1.userId=u1.id
where u1.parentId=u.id
)
end AS other1"), DB::raw("case when u.role = 'model' then (
select MAX(e2.otherMember) 
from users u2 
join earningsettings e2 on e2.userId=u2.parentId
where u2.id=u.parentId
) 
when u.role='studio' then (
select MAX(e2.otherMember)
 from users u2 
join earningsettings e2 on e2.userId=u2.id
where u2.parentId=u.id
)
when u.role='admin' then (
select MAX(e2.otherMember) 
from users u2 
join users u3 on u3.parentId=u2.id 
join earningsettings e2 on e2.userId=u3.id
 where u2.parentId=u.id
)
end AS other2")
          )
          ->join('users as u', 'u.id', '=', 'earningsettings.userId')
          ->where('earningsettings.id', $id)
          ->first()
      ;
    }
    return null;
  }
  
  public static function getCommission($userId){
    $earningSetting = EarningSettingModel::where('userId', $userId)->first();
    return $earningSetting->referredMember;
  }

}
