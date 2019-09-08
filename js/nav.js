// $('ul').hide().slideDown(900);

$logo = $('.logo');
$logo.hide().delay(500);
$logo.slideDown(800);

$('a.cta').hide().delay(1300).show(600);




// add this in the css file

$logo.css({
    // 'text-decoration' : 'underline'
    'border' : '3px solid #DB2955 ',
    'border-radius' : '8px',
    'color' : '#FFEDDF'
});