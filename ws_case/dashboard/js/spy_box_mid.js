(function ($) {
$.fn.simpleSpy = function(limit, interval) {
  limit    = limit || 4;
  interval = interval || 40000;

  return this.each(function() {
      // 1. setup
          // capture a cache of all the Interesting title s
          // chomp the list down to limit li elements
      var $list       = $(this),
          items       = [], // uninitialised
          currentItem = limit,
          total       = 0, // initialise later on
          start       = 0,//when the effect first starts
          startdelay  = 4000,
          height      = $list.find('> li:first').height(),
          theMargin   = $list.find('> li:first').css('marginTop') + $list.find('> li:first').css('marginBottom');
          // height      = 120,
          // theMargin   = 100;

      // capture the cache
      $list.find('> li').each(function() {
          items.push('<li>' + $(this).html() + '</li>');
      });

      total = items.length;

      $list.wrap('<div class="spyWrapper"></div>').parent().css({height:height+theMargin*limit});

      $list.find('> li').filter(':gt(' + (limit - 1) + ')').remove();

      // 2. effect
      function spy() {
          // insert a new item with opacity and height of zero
          var $insert = $(items[currentItem]).css({
              height:0,
              opacity:0,
              display:'none'
          }).prependTo($list);

          // fade the LAST item out
          $list.find('> li:last').animate({opacity:0}, 1000, function() {
              // increase the height of the NEW first item
               $insert.animate({height:height}, 1000).animate({opacity:1}, 1000);
               $(this).remove();
          });

          currentItem++;
          if (currentItem >= total) {
              currentItem = 0;
          }

          setTimeout(spy, interval)
      }

      if (start < 1) {
             setTimeout(spy,startdelay);
              start++;
          } else {
              spy();
          }

  });
};

})(jQuery);
