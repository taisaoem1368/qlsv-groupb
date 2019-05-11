<option selected disabled="disabled">Chọn sinh viên</option>
@foreach($student as $value)
<option value="{{$value['student_id']}}">{{$value['student_code']}}</option>
@endforeach