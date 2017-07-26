<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="styles.css">
  <title>SampleContactForm</title>
</head>

<body style="background:darkgray">
    <div id="container">
      <h1>Contact Us</h1>
      <form action="confirm.php" method="post">
        <dl>
          <dt>Name<span>※</span></dt>
          <dd><input type="text" name="name" size="80" class="validate"></dd>
          <dt>Email<span>※</span></dt>
          <dd><input type="text" value="" size="80" name="email" class="validate email"></dd>
          <dt>Phone<span>※</span></dt>
          <dd><input type="text" name="phone" size="11" maxlength="11" class="validate number"></dd>
          <dt>Title<span>※</span></dt>
          <dd><input type="text" name="title" size="80" class="validate"></dd>
          <dt>Message<span>※</span></dt>
          <dd><textarea id="message" name="message" rows="10" cols="60" class="validate"></textarea></dd>
        </dl>
        <p><input type="submit" value="Submit"></p>
      </form>
    </div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script>
$(function(){
  $("form").submit(function(){

    //エラーの初期化
    $("p.error").remove();
    $("dl dd").removeClass("error");

    $("input[type='text'].validate").each(function(){
      //必須項目のチェック
      if($(this).hasClass("validate")){
        if($(this).val()==""){
          $(this).parent().prepend("<p class='error'>Required</p>");
        }
      }

      // 数値のチェック
      if($(this).hasClass("number")){
        if(isNaN($(this).val())){
          $(this).parent().prepend("<p class='error'>phone number only</p>");
        }
      }

      //メールアドレスのチェック
      if($(this).hasClass("email")){
        if($(this).val() && !$(this).val().match(/.+@.+\..+/g)){
          $(this).parent().prepend("<p class='error'>Email address only</p>");
        }
      }
    });

      //エラーの際の処理
      if($("p.error").length > 0){
        $("p.error").parent().addClass("error");
        return false;
      };
  });
});
</script>
</body>
</html>
