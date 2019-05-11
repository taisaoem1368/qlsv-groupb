<option selected disabled="disabled">Chọn mã lớp</option>
@foreach($class as $value)
<option value="{{$value['class_id']}}">{{$value['class_code']}}</option>
@endforeach