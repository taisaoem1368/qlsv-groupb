<?php
use Illuminate\Session\TokenMismatchException;
//use LaravelAcl\Authentication\Controllers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//========================================== LOGIN ==========================================\\
Route::get('/auth/login', ['as' => 'getLogin', 'middleware' => 'login_md', 'uses' => 'Auth\LoginController@getLogin']);
Route::post('/auth/post-login', ['as' => 'postLoginWebsite', 'uses' => 'Auth\LoginController@postLoginWebsite']);
Route::get('/logout', ['as' => 'LogoutWebsite', 'uses' => 'Auth\LoginController@Logout']);
Route::get('/{id?}', ['middleware' => 'login_md', 'uses' => 'Auth\LoginController@getLogin']);
//========================================== END LOGIN ==========================================\\

//==========================TEST function controller
// Route::get('test', 'WelcomeController@test');


//===================================================================================================

//======================================== ADMIN ROUTE ==================================================\\
Route::group(['prefix' => 'admin', 'middleware' => 'admin_md'], function(){
    Route::get('/profileadmin', ['as' => 'getProfileAdmin', 'uses' => 'TeacherController@getProfileAdmin']);
    Route::post('/profileadmin', ['as' => 'postProfileAdmin', 'uses' => 'TeacherController@postProfileUser']);
    Route::get('/{id?}', 'TTKLController@dashboard');
    
    //==> THÔNG TIN KỶ LUẬT <==\\
    Route::group(['prefix' => 'disciplinary-information'], function() {
        //-------------------Excel------------------//
        Route::get('/add-from-file', ['as' => 'getAddFromFile', 'uses' => 'TTKLController@getAddFromFile']);
        Route::get('/delete-all', ['as' => 'deleteAllFromFile', 'uses' => 'TTKLController@deleteAllFromFile']);
        Route::get('/delete-student/{id}', ['as' => 'deleteStudentEx', 'uses' => 'TTKLController@deleteStudentEx']);
        Route::post('/import-excel', ['as' => 'importExcelTTKL', 'uses' => 'TTKLController@importExcelTTKL']);
        Route::get('/edit-student-json/{id}', ['as' => 'editStudentInJson', 'uses' => 'TTKLController@editStudentInJson']);
        Route::get('/post-edit-json', ['as' => 'posteditStudentInJson', 'uses' => 'TTKLController@posteditStudentInJson']);
        Route::get('/update-data-to-database', ['as' => 'updateDataToDataBase', 'uses' => 'TTKLController@updateDataToDataBase']);
        Route::get('/update-data-to-database-question', ['as' => 'updateDataToDataBaseQuestion', 'uses' => 'TTKLController@updateDataToDataBaseQuestion']);
        Route::get('/export-thong-tin-ky-luat', ['as' => 'getExportTTKL', 'uses' => 'TTKLController@getExportTTKL']);
        Route::post('/export-thong-tin-ky-luat', ['as' => 'postExportTTKL', 'uses' => 'TTKLController@postExportTTKL']);

        Route::get('/download-ttkl-temp', ['as' => 'downLoadTTKLTemp', 'uses' => 'TTKLController@downLoadTTKLTemp']);
        Route::get('/update-dicision', ['as' => 'UpdateSQD', 'uses' => 'TTKLController@UpdateSQD']);
        Route::post('/update-dicision', ['as' => 'postUpdateSQD', 'uses' => 'TTKLController@postUpdateSQD']);
        //-----------------------------------------//
        Route::get('/list', 'TTKLController@index');
        Route::get('/add', ['as' => 'getAddDI', 'uses' => 'TTKLController@getAddDiscipline']);
        Route::get('/edit/{id}', ['as' => 'getEditDI', 'uses' => 'TTKLController@getEditDiscipline']);//get Sửa
        Route::post('/edit', ['as' => 'postEditDI', 'uses' => 'TTKLController@postEditDiscipline']);//post Sửa
        Route::post('/add', ['as' => 'postAddDI', 'uses' => 'TTKLController@postAddDiscipline']);
        Route::post('/delete', ['as' => 'postDeleteTTKL', 'uses' => 'TTKLController@postDeleteTTKL']);//post delete
        Route::get('/change-class-add/{id}', ['as' => 'getChangeClass', 'uses' => 'TTKLController@getChangeClass']);
        Route::get('/change-course-add/{id}', ['as' => 'getChangeCourse', 'uses' => 'TTKLController@getChangeCourse']);
        Route::get('/list/search', ['as' => 'getSearchTTKL', 'uses' => 'TTKLController@getSearchTTKL']);
        //Ajax modal di_student
        Route::get('/find-di-student-id/{id}', ['as' => 'findDiStudent', 'uses' => 'TTKLController@findDiStudent']);
    });
    //==> END THÔNG TIN KỶ LUẬT <==\\

    //==> CLASS <==\\
    Route::group(['prefix' => 'class'], function(){
    	Route::get('/list', 'ClassController@index');
        Route::get('/add', ['as' => 'getAddClass', 'uses' => 'ClassController@getAddClass']);
        Route::post('/add', ['as' => 'postAddClass', 'uses' => 'ClassController@postAddClass']);
        Route::get('/edit/{id}', ['as' => 'getEditClass', 'uses' => 'ClassController@getEditClass']);//get Sửa
        Route::post('/edit', ['as' => 'postEditClass', 'uses' => 'ClassController@postEditClass']);//post Sửa
        Route::post('/delete', ['as' => 'postDeleteClass', 'uses' => 'ClassController@postDeleteClass']);//post delete
        Route::get('/list/search', ['as' => 'getSearchClass', 'uses' => 'ClassController@getSearch']);
        Route::get('/add-from-file', ['as' => 'getAddFromFileClass', 'uses' => 'ClassController@getAddFromFileClass']);
        //===EXCEL===\\
        Route::post('/import-excel', ['as' => 'postClassImportExcel', 'uses' => 'ClassController@postClassImportExcel']);
        Route::get('/delete-json-class', ['as' => 'deleteClassJson' , 'uses' => 'ClassController@deleteClassJson']);
        Route::get('/update-json-class-to-database', ['as' => 'postAddJsonToDataBase', 'uses' => 'ClassController@postAddJsonToDataBase']);
        Route::get('/dowload-class-temp', ['as' => 'downLoadClassTemp', 'uses' => 'ClassController@downLoadClassTemp']);

    });

    //==> END CLASS <==\\

    //==> MAJOR <==\\
    Route::group(['prefix' => 'major'], function(){
        Route::get('/list', 'MajorController@index'); //danh sách
        Route::get('/add', ['as' => 'getAddMajor', 'uses' => 'MajorController@getAddMajor']);//get Thêm
        Route::post('/add', ['as' => 'postAddMajor', 'uses' => 'MajorController@postAddMajor']);//post Thêm
        Route::get('/edit/{id}', ['as' => 'getEditMajor', 'uses' => 'MajorController@getEditMajor']);//get Sửa
        Route::post('/edit', ['as' => 'postEditMajor', 'uses' => 'MajorController@postEditMajor']);//post Sửa
        Route::post('/delete', ['as' => 'postDeleteMajor', 'uses' => 'MajorController@postDeleteMajor']);//post delete
        Route::get('/search', ['as' => 'getSearch', 'uses' => 'MajorController@getSearch']);
    });
    //==> END MAJOR <==\\

     //==> TEACHER <==\\
    Route::group(['prefix' => 'teacher'], function(){
        Route::get('/list', 'TeacherController@index'); //danh sách
        Route::get('/add', ['as' => 'getAddTeacher', 'uses' => 'TeacherController@getAddTeacher']);//get Thêm
        Route::post('/add', ['as' => 'postAddTeacher', 'uses' => 'TeacherController@postAddTeacher']);//post Thêm
        Route::get('/edit/{id}', ['as' => 'getEditTeacher', 'uses' => 'TeacherController@getEditTeacher']);//get Sửa
        Route::post('/edit', ['as' => 'postEditTeacher', 'uses' => 'TeacherController@postEditTeacher']);//post Sửa
        Route::post('/delete', ['as' => 'postDeleteTeacher', 'uses' => 'TeacherController@postDeleteTeacher']);//post delete
        Route::get('/search', ['as' => 'getSearchTeacher', 'uses' => 'TeacherController@getSearchTeacher']);
    });
    //==> END TEACHER <==\\

//==> Course <==\\
    Route::group(['prefix' => 'course'], function(){
        Route::get('/list', 'CourseController@index'); //danh sách
        Route::get('/add', ['as' => 'getAddCourse', 'uses' => 'CourseController@getAddCourse']);//get Thêm
        Route::post('/add', ['as' => 'postAddCourse', 'uses' => 'CourseController@postAddCourse']);//post Thêm
        Route::get('/edit/{id}', ['as' => 'getEditCourse', 'uses' => 'CourseController@getEditCourse']);//get Sửa
        Route::post('/edit', ['as' => 'postEditCourse', 'uses' => 'CourseController@postEditCourse']);//post Sửa
        Route::post('/delete', ['as' => 'postDeleteCourse', 'uses' => 'CourseController@postDeleteCourse']);//post delete
        Route::get('/list/search', ['as' => 'getSearchCourse', 'uses' => 'CourseController@getSearch']);
    });

    //==> end Course <==\\
            
    //==> Student <==\\
    Route::group(['prefix' => 'student'], function(){
        Route::get('/list', 'StudentController@index'); //danh sách
        Route::get('/major/{id}', ['as' => 'getClassValue', 'uses' => 'StudentController@getClassValue']); //danh sách
        Route::get('/add', ['as' => 'getAddStudent', 'uses' => 'StudentController@getAddStudent']);//get Thêm
        Route::post('/add', ['as' => 'postAddStudent', 'uses' => 'StudentController@postAddStudent']);//post Thêm
        Route::get('/edit/{id}', ['as' => 'getEditStudent', 'uses' => 'StudentController@getEditStudent']);//get Sửa
        Route::post('/edit', ['as' => 'postEditStudent', 'uses' => 'StudentController@postEditStudent']);//post Sửa
        Route::post('/delete', ['as' => 'postDeleteStudent', 'uses' => 'StudentController@postDeleteStudent']);//post delete
        Route::get('/list/search', ['as' => 'getSearchStudent', 'uses' => 'StudentController@getSearch']);
    });

    //==> end Student <==\\


                //==> Discipline <==\\
    Route::group(['prefix' => 'discipline'], function(){
        Route::get('/list', 'DisciplineController@index'); //danh sách
        Route::get('/add', ['as' => 'getAddDiscipline', 'uses' => 'DisciplineController@getAddDiscipline']);//get Thêm
        Route::post('/add', ['as' => 'postAddDiscipline', 'uses' => 'DisciplineController@postAddDiscipline']);//post Thêm
        Route::get('/edit/{id}', ['as' => 'getEditDiscipline', 'uses' => 'DisciplineController@getEditDiscipline']);//get Sửa
        Route::post('/edit', ['as' => 'postEditDiscipline', 'uses' => 'DisciplineController@postEditDiscipline']);//post Sửa
        Route::post('/delete', ['as' => 'postDeleteDiscipline', 'uses' => 'DisciplineController@postDeleteDiscipline']);//post delete
        Route::get('/list/search', ['as' => 'getSearchDiscipline', 'uses' => 'DisciplineController@getSearch']);
    });

    //==> end Discipline <==\\

    //==> Absent <==\\
    Route::group(['prefix' => 'absent'], function(){
        Route::get('/list', 'absentController@index'); //danh sách
        Route::get('/add', ['as' => 'getAddAbsent', 'uses' => 'absentController@getAddAbsent']);//get Thêm
        Route::post('/add', ['as' => 'postAddAbsent', 'uses' => 'absentController@postAddAbsent']);//post Thêm
        Route::get('/edit/{id}', ['as' => 'getEditAbsent', 'uses' => 'absentController@getEditAbsent']);//get Sửa
        Route::post('/edit', ['as' => 'postEditAbsent', 'uses' => 'absentController@postEditAbsent']);//post Sửa
        Route::post('/delete', ['as' => 'postDeleteAbsent', 'uses' => 'absentController@postDeleteAbsent']);//post delete
        Route::get('/list/search', ['as' => 'getSearchAbsent', 'uses' => 'absentController@getSearchAbsent']);
        Route::get('/edit/change-class-add/{id}', ['as' => 'getChangeClassAbsent', 'uses' => 'TTKLController@getChangeClass']);
        Route::get('/edit/change-course-add/{id}', ['as' => 'getChangeCourseAbsent', 'uses' => 'TTKLController@getChangeCourse']);
        Route::get('/add-from-file', ['as' => 'getAddFromFileAbsent', 'uses' => 'absentController@getAddFromFileAbsent']);
        Route::post('/import-excel-absent', ['as' => 'importExcelAbsent', 'uses' => 'absentController@importExcelAbsent']);
        Route::get('/delete-data-temp', ['as' => 'getDeleteJsonAbsent', 'uses' => 'absentController@getDeleteJsonAbsent']);
        Route::get('/update-data-absent-to-database-question', ['as' => 'UpdateDataJsonFileToDataBaseQuestion', 'uses' => 'absentController@UpdateDataJsonFileToDataBaseQuestion']);
        Route::get('/update-data-absent-to-database', ['as' => 'UpdateDataJsonFileToDataBase', 'uses' => 'absentController@UpdateDataJsonFileToDataBase']);

        Route::get('/dowload-absent-temp', ['as' => 'downloadAnsentTemp', 'uses' => 'absentController@downloadAnsentTemp']);

    });

    //==> end Absent <==\\
});
//============================ END ADMIN ROUTE ==================================================\\

//============================ USER ROUTE ==================================================\\
Route::group(['prefix' => 'user', 'middleware' => 'user_md'], function(){
    Route::get('/profile', ['as' => 'getProfile', 'uses' => 'TeacherController@getProfile']);
    Route::post('/profile', ['as' => 'postProfileUser', 'uses' => 'TeacherController@postProfileUser']);
    Route::get('/{id?}', 'TTKLController@indexUser');
    //=========> disciplinary information <===============\\
    
    Route::group(['prefix' => 'discipline'], function(){
        Route::get('/list', 'TTKLController@getUserList');
        Route::get('/update/{id}', ['as' => 'getUserUpdate', 'uses' => 'TTKLController@getUserUpdate']);
        Route::post('/update', ['as' => 'postUserUpdate', 'uses' => 'TTKLController@postUserUpdate']);
        Route::get('/search', ['as' => 'getSearchUser', 'uses' => 'TTKLController@getSearchUser']);

    });

    //===============> absent ================================//
    Route::group(['prefix' => 'absent'], function(){
        Route::get('/list', 'absentController@getUserListAbsent');
        Route::get('/search', ['as' => 'getSearchUserAbsent', 'uses' => 'absentController@getSearchUserAbsent']);

    });

});
//========================= END USER ROUTE ==================================================\\


