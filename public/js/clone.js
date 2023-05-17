jQuery(function($) {
    // for Activité 1 : Vidéos de formation vidéos 2
    $('#btn1-quizz').click(function() {
        var button = $('#item_details-1').clone();
        button.removeAttr('id'); //ID of an element must be uniue
        $("#new_item_details-1").append(button);
        $('.removeitem').show();
    });
    $('#remove_item1').click(function(e) {
        $("#new_item_details-1 > .form-group").last().remove();
        $('.removeitem').toggle(!$("#new_item_details-1").is(":empty"));
        e.preventDefault();
    });

    // for Activité 1 : Vidéos de formation vidéos 2
    $('#btn2-quizz').click(function() {
        var button = $('#item_details-2').clone();
        button.removeAttr('id'); //ID of an element must be uniue
        $("#new_item_details-2").append(button);
        $('.removeitem').show();
    });
    $('#remove_item2').click(function(e) {
        $("#new_item_details-2 > .form-group").last().remove();
        $('.removeitem').toggle(!$("#new_item_details-2").is(":empty"));
        e.preventDefault();
    });

    // for Activité 1 : Vidéos de formation vidéos 3
    $('#btn3-quizz').click(function() {
        var button = $('#item_details-3').clone();
        button.removeAttr('id'); //ID of an element must be uniue
        $("#new_item_details-3").append(button);
        $('.removeitem').show();
    });
    $('#remove_item3').click(function(e) {
        $("#new_item_details-3 > .form-group").last().remove();
        $('.removeitem').toggle(!$("#new_item_details-3").is(":empty"));
        e.preventDefault();
    });



    // for audio 1 
    $('#btn1-audio-quizz').click(function() {
        var button = $('#item_details-audio-1').clone();
        button.removeAttr('id'); //ID of an element must be uniue
        $("#new_item_details-audio-1").append(button);
        $('.removeitem').show();
    });
    $('#remove_item1-audio').click(function(e) {
        $("#new_item_details-audio-1 > .form-group").last().remove();
        $('.removeitem').toggle(!$("#new_item_details-audio-1").is(":empty"));
        e.preventDefault();
    });

    // for audio2 
    $('#btn2-audio-quizz').click(function() {
        var button = $('#item_details-audio-2').clone();
        button.removeAttr('id'); //ID of an element must be uniue
        $("#new_item_details-audio-2").append(button);
        $('.removeitem').show();
    });
    $('#remove_item2-audio').click(function(e) {
        $("#new_item_details-audio-2 > .form-group").last().remove();
        $('.removeitem').toggle(!$("#new_item_details-audio-2").is(":empty"));
        e.preventDefault();
    });

    // for audio 3 : Vidéos de formation vidéos 3
    $('#btn3-audio-quizz').click(function() {
        var button = $('#item_details-audio-3').clone();
        button.removeAttr('id'); //ID of an element must be uniue
        $("#new_item_details-audio-3").append(button);
        $('.removeitem').show();
    });
    $('#remove_item3-audio').click(function(e) {
        $("#new_item_details-audio-3 > .form-group").last().remove();
        $('.removeitem').toggle(!$("#new_item_details-audio-3").is(":empty"));
        e.preventDefault();
    });


    // for activité et choix 1
    $('#ajout-activite').click(function() {
        var block = $('#clone-activite-parcours-1').clone();
        block.removeAttr('id'); //ID of an element must be uniue
        $("#new_block-parcour-1").append(block);
        $('#block-input1').show();
    });
    $('#remove_programme-1').click(function(e) {
        $("#new_block-parcour-1 > div").last().remove();
        $('#block-input1').toggle(!$("#new_block-parcour-1").is(":empty"));
        e.preventDefault();
    });

    // for activité et choix 2
    $('#ajout-activite-2').click(function() {
        var block = $('#clone-activite-parcours-2').clone();
        block.removeAttr('id'); //ID of an element must be uniue
        $("#new_block-parcour-2").append(block);
        $('#block-input2').show();
    });
    $('#remove_programme-2').click(function(e) {
        $("#new_block-parcour-2 > div").last().remove();
        $('#block-input2').toggle(!$("#new_block-parcour-2").is(":empty"));
        e.preventDefault();
    });

});