$nameform = $('#nameform');
$editname = $('#editname');
$canceleditname = $('#canceleditname');

$emailform = $('#emailform');
$editemail = $('#editemail');
$canceleditemail = $('#canceleditemail');

$passwordform = $('#passwordform');
$editpassword = $('#editpassword');
$canceleditpassword = $('#canceleditpassword');


$passwordform.hide();
$nameform.hide();
$emailform.hide();


// name show form - hide form 
$editname.on('click', function(e) {   
    e.preventDefault();
    $editname.slideUp(500);
    $nameform.slideDown(500);
});

$canceleditname.on('click', function(e) {   
    e.preventDefault();
    $nameform.slideUp(500);
    $editname.slideDown(500);
});

//email show form - hide form
$editemail.on('click', function(e){   
    e.preventDefault();
    $editemail.slideUp(500);
    $emailform.slideDown(500);
});

$canceleditemail.on('click', function(e) {   
    e.preventDefault();
    $emailform.slideUp(500);
    $editemail.slideDown(500);
});


// password show hide form
$editpassword.on('click', function(e) {   
    e.preventDefault();
    $editpassword.slideUp(500);
    $passwordform.slideDown(500);
});

$canceleditpassword.on('click', function(e) {   
    e.preventDefault();
    $passwordform.slideUp(500);
    $editpassword.slideDown(500);
});