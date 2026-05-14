<div class="preview clearfix light">
        <div class="container">
        <div class="content"><style>@import url(http://fonts.googleapis.com/css?family=Raleway:400,200);
#cssmenu,
#cssmenu ul,
#cssmenu ul li,
#cssmenu ul li a {
  margin: 0;
  padding: 0;
  border: 0;
  list-style: none;
  line-height: 1;
  display: block;
  position: relative;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
#cssmenu {
  width: 220px;
  font-family: Raleway, sans-serif;
  color: #ffffff;
}
#cssmenu ul ul {
  display: none;
}
#cssmenu > ul > li.active > ul {
  display: block;
}
.align-right {
  float: right;
}
#cssmenu > ul > li > a {
  padding: 16px 22px;
  cursor: pointer;
  z-index: 2;
  font-size: 16px;
  text-decoration: none;
  color: #ffffff;
  background: #3ab4a6;
  -webkit-transition: color .2s ease;
  -o-transition: color .2s ease;
  transition: color .2s ease;
}
#cssmenu > ul > li > a:hover {
  color: #d8f3f0;
}
#cssmenu ul > li.has-sub > a:after {
  position: absolute;
  right: 26px;
  top: 19px;
  z-index: 5;
  display: block;
  height: 10px;
  width: 2px;
  background: #ffffff;
  content: "";
  -webkit-transition: all 0.1s ease-out;
  -moz-transition: all 0.1s ease-out;
  -ms-transition: all 0.1s ease-out;
  -o-transition: all 0.1s ease-out;
  transition: all 0.1s ease-out;
}
#cssmenu ul > li.has-sub > a:before {
  position: absolute;
  right: 22px;
  top: 23px;
  display: block;
  width: 10px;
  height: 2px;
  background: #ffffff;
  content: "";
  -webkit-transition: all 0.1s ease-out;
  -moz-transition: all 0.1s ease-out;
  -ms-transition: all 0.1s ease-out;
  -o-transition: all 0.1s ease-out;
  transition: all 0.1s ease-out;
}
#cssmenu ul > li.has-sub.open > a:after,
#cssmenu ul > li.has-sub.open > a:before {
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
}
#cssmenu ul ul li a {
  padding: 14px 22px;
  cursor: pointer;
  z-index: 2;
  font-size: 14px;
  text-decoration: none;
  color: #dddddd;
  background: #49505a;
  -webkit-transition: color .2s ease;
  -o-transition: color .2s ease;
  transition: color .2s ease;
}
#cssmenu ul ul ul li a {
  padding-left: 32px;
}
#cssmenu ul ul li a:hover {
  color: #ffffff;
}
#cssmenu ul ul > li.has-sub > a:after {
  top: 16px;
  right: 26px;
  background: #dddddd;
}
#cssmenu ul ul > li.has-sub > a:before {
  top: 20px;
  background: #dddddd;
}
</style>
<div id="cssmenu">
<ul>
   <li><a href="#">Home</a></li>
   <li class="active has-sub open"><a href="#">Products</a>
      <ul>
         <li class="has-sub"><a href="#">Product 1</a>
            <ul>
               <li><a href="#">Sub Product</a></li>
               <li><a href="#">Sub Product</a></li>
            </ul>
         </li>
         <li class="has-sub"><a href="#">Product 2</a>
            <ul>
               <li><a href="#">Sub Product</a></li>
               <li><a href="#">Sub Product</a></li>
            </ul>
         </li>
      </ul>
   </li>
   <li><a href="#">About</a></li>
   <li><a href="#">Contact</a></li>
</ul>
</div></div>
        </div>
              </div>
              <!-- jQuery -->
              <script src="http://code.jquery.com/jquery-latest.min.js"></script>

              <!-- Icon Library -->
              <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

              <script type="text/javascript">
              $('#cssmenu li.active').addClass('open').children('ul').show();
              $('#cssmenu li.has-sub>a').on('click', function(){
                $(this).removeAttr('href');
                var element = $(this).parent('li');
                if (element.hasClass('open')) {
                  element.removeClass('open');
                  element.find('li').removeClass('open');
                  element.find('ul').slideUp(200);
                } else {
                  element.addClass('open');
                  element.children('ul').slideDown(200);
                  element.siblings('li').children('ul').slideUp(200);
                  element.siblings('li').removeClass('open');
                  element.siblings('li').find('li').removeClass('open');
                  element.siblings('li').find('ul').slideUp(200);
                }
              });

              </script>
