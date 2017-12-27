jQuery.noConflict();
jQuery(function() {
document.getElementById('sharer').onclick = function () {
  var url = 'https://www.facebook.com/sharer/sharer.php?u=';
  url += encodeURIComponent(location.href);
  window.open(url, 'fbshare', 'width=640,height=320');
};
});