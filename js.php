
<h4 id="demo">ddddd</h4>
<input type="button" onclick="myFunction()">
<script>
    function myFunction()
    {
        var x=document.getElementById("demo").innerHTML;
        alert(x);
        if(x==""||isNaN(x))
        {
            alert("Not Numeric");
        }
    }

    // document.write('<h1>This is a heading</h1>');
    //alert(1);
    x = document.getElementById('aaa');
    x.innerHTML='asdas';
    x.style.color="#ff0000";
</script>