<html>
<body onload="document.webxform.submit()">
<form action="{{$url}}" name="webxform" method="POST">
     @foreach($fields as $key=>$val)
   <input type="hidden" name="{{$key}}" value="{{$val}}" />
      @endforeach
   </form>

   Please wait for a moment ..................

</body>
</html>
