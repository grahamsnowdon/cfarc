$(document).ready(function(){  
  // use live() to handle dynamically added buttons (pre jQuery v1.7)  
  $("form").on("click", "button", function(){ 
    var f = $(this).get(0).form;  
  
    if (typeof(f) !== 'undefined') {  
      if (this.type && this.type != 'submit')  
        return;  
  
      if (this.name) {  
        this.trueName = this.name;  
        this.name = '';  
      }  
  
      $("input[type='hidden'][name='"+this.trueName+"']", f).remove();  
  
      if (typeof(this.attributes.value) !== 'undefined')  
        $(f)  
          .append('<input type="hidden" name="'+this.trueName+  
            '" value="'+this.attributes.value.value+'">');  
  
      $(f).trigger('submit');  
      return false;  
    }  
  });
    $("form").on("keypress", "input,select", function(e){  
    if (e.keyCode == 13)  
      $("button:not(disabled):first", this.form).trigger('click');  
  });   
});  
/* 
Note: As of jQuery v1.7, live() has been deprecated. You can replace 
that line above with the following if you're using the latest jQuery: 
  $("form").on("click", "button", function(){ 
*/ 