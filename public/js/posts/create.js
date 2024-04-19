window.onload = function(){
  //preview
var preview = document.getElementById('preview');
var image = document.getElementById('image');
image.addEventListener('change',function(evt){
  var file = evt.target.files[0];
  if(file){
    var reader = new FileReader();
    reader.onload = function(e){
      preview.src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
});
}
