<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{gs('site_name')}}</title>
</head>

<body>
<form action="{{$data->url}}" method="{{$data->method}}" id="auto_submit" class="disableSubmission">
    @foreach($data->val as $k=> $v)
        <input type="hidden" name="{{$k}}" value="{{$v}}">
    @endforeach
</form>
<script>
	"use strict";
    document.getElementById("auto_submit").submit();
</script>
</body>

</html>
