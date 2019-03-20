<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model {

   public static function listbills($id=null) {
     $value=DB::table('bills')->orderBy('duedate', 'asc')->get();
     return $value;
   }

   // public static function insertData($data) {

   //   $value=DB::table('users')->where('name', $data['name'])->get();
   //   if($value->count() == 0){
   //     $insertid = DB::table('users')->insertGetId($data);
   //     return $insertid;
   //   } else {
   //     return 0;
   //   }

   // }

   // public static function updateData($id,$data) {
   //    DB::table('users')->where('id', $id)->update($data);
   // }

   // public static function deleteData($id=0) {
   //    DB::table('users')->where('id', '=', $id)->delete();
   // }

}
