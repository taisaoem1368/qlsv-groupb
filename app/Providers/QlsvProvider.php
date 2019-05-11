<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Models\classModel;
use App\Http\Models\teacher;
use App\Http\Models\course;
use App\Http\Models\major;
use App\Http\Models\role;
use App\Http\Models\user;
use App\Http\Models\disciplinary_information;
use App\Http\Models\discipline;
use Validator;
use Auth;
class QlsvProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

      view()->composer(['admin.index'], function($view){
            $obj_class = new classModel();
            $kq = $obj_class->countAllClass();
            return $view->with('classdangquanliall', $kq);
        });

      view()->composer(['admin.index'], function($view){
            $obj_di = new disciplinary_information();
            $kq = $obj_di->countSoSinhVienBiKyLuatDaComfirmAll();
            return $view->with('sinhvienbikyluatdacomfirmall', $kq);
        });

      view()->composer(['admin.index'], function($view){

            $obj_di = new disciplinary_information();
            $kq = $obj_di->countSoSinhVienBiKyLuatChuaComfirmAll();
            return $view->with('sinhvienbikyluatchuacomfirmall', $kq);
        });

        view()->composer(['admin.index'], function($view){
            $obj_di = new disciplinary_information();
            $kq = $obj_di->countSoSinhVienBiKyLuatAll();
            return $view->with('sinhvienbikyluatall', $kq);
        });

        view()->composer(['user.index'], function($view){
            $obj_teacher = new teacher();
            $teacher_code = Auth::user()->user_teacher_code;
            $teacher_id = $obj_teacher->getTeacherIdByTeacherCode($teacher_code);
            $obj_class = new classModel();
            $kq = $obj_class->countClassDangQuanLy($teacher_id);
            return $view->with('classdangquanli', $kq);
        });

        view()->composer(['user.index'], function($view){
            $obj_teacher = new teacher();
            $obj_di = new disciplinary_information();
            $teacher_code = Auth::user()->user_teacher_code;
            $teacher_id = $obj_teacher->getTeacherIdByTeacherCode($teacher_code);
            $kq = $obj_di->countSoSinhVienBiKyLuatDaComfirm($teacher_id);
            return $view->with('sinhvienbikyluatdacomfirm', $kq);
        });

        view()->composer(['user.index'], function($view){
            $obj_teacher = new teacher();
            $obj_di = new disciplinary_information();
            $teacher_code = Auth::user()->user_teacher_code;
            $teacher_id = $obj_teacher->getTeacherIdByTeacherCode($teacher_code);
            $kq = $obj_di->countSoSinhVienBiKyLuatChuaComfirm($teacher_id);
            return $view->with('sinhvienbikyluatchuacomfirm', $kq);
        });

        view()->composer(['user.index'], function($view){
            $obj_teacher = new teacher();
            $obj_di = new disciplinary_information();
            $teacher_code = Auth::user()->user_teacher_code;
            $teacher_id = $obj_teacher->getTeacherIdByTeacherCode($teacher_code);
            $kq = $obj_di->countSoSinhVienBiKyLuat($teacher_id);
            return $view->with('sinhvienbikyluat', $kq);
        });

        view()->composer(['admin.ttkyluat.tables', 'user.ttkyluat.tables', 'user.index', 'admin.index', 'admin.absent.tables', 'user.absent.tables'], function($view){
            $obj_di = new disciplinary_information();
            $kq = $obj_di->returnYearMax();
            return $view->with('nam', $kq);
        });

        view()->composer(['admin.ttkyluat.tables', 'user.ttkyluat.tables', 'user.index', 'admin.index', 'admin.absent.tables', 'user.absent.tables'], function($view){
          $obj_di = new disciplinary_information();
          $kq = $obj_di->returnSemesterMax();
          return $view->with('hocky', $kq);
        });


        view()->composer(['admin.ttkyluat.add', 'admin.ttkyluat.edit', 'admin.ttkyluat.add-file', 'admin.absent.add', 'admin.absent.edit'], function($view){
            $discipline = discipline::all();
            return $view->with('discipline', $discipline);
        });

        view()->composer(['admin.ttkyluat.add', 'admin.ttkyluat.edit', 'admin.ttkyluat.add-file', 'admin.absent.add', 'admin.absent.edit'], function($view){
            $class = classModel::all();
            return $view->with('class', $class);
        });

        view()->composer(['admin.class.add', 'admin.class.edit', 'admin.ttkyluat.add', 'admin.ttkyluat.edit', 'admin.absent.add', 'admin.absent.edit'], function($view){
            $course = course::all();
            return $view->with('course', $course);
        });
        view()->composer(['admin.class.add', 'admin.class.edit'], function($view){
            $teacher = teacher::join('users', 'user_teacher_code', 'teacher_code')->where('user_role_id', 3)->get();
            return $view->with('teacher', $teacher);
        });
        view()->composer(['admin.class.add', 'admin.class.edit', 'admin.ttkyluat.add-file'], function($view){
            $major = major::all();
            return $view->with('major', $major);
        });
        view()->composer(['admin.teacher.add', 'admin.teacher.edit', 'user.profile'], function($view){
            $role = role::all();
            return $view->with('role', $role);
        });

        // view()->composer('user.index', function($view) {
        //     $teacher_id = 2;
        //     $obj = new disciplinary_information();
        //     $teacher = $obj->getUserList($teacher_id, null);
        //     $obj = new disciplinary_information();
        //     $teacher_confirm_flase = $obj->getSearch($teacher_id, "", "cph");
        //     $teacher_confirm_true = $obj->getConfirmed($teacher_id);
        //     $obj_class = new classModel();
        //     $teacher_class = $obj_class->getClassManage($teacher_id);
        //     return $view->with(['teacher' => $teacher, 'teacher_confirm_flase' => $teacher_confirm_flase, 'teacher_confirm_true' => $teacher_confirm_true, 'teacher_class' => $teacher_class]);
        // });

        Validator::extend('date_multi_format', function($attribute, $value, $formats) {
          // iterate through all formats
              foreach($formats as $format) {

            // parse date with current format
                $parsed = date_parse_from_format($format, $value);

            // if value matches given format return true=validation succeeded 
                if ($parsed['error_count'] === 0 && $parsed['warning_count'] === 0) {
                  return true;
              }
          }

          // value did not match any of the provided formats, so return false=validation failed
          return false;
        });

        Validator::extend('not_found', function($attribute, $value, $formats) {
          // iterate through all formats
              foreach($formats as $format) {

            // parse date with current format
                $parsed = date_parse_from_format($format, $value);

            // if value matches given format return true=validation succeeded 
                if ($parsed['error_count'] === 0 && $parsed['warning_count'] === 0) {
                  return true;
              }
          }

          // value did not match any of the provided formats, so return false=validation failed
          return false;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
