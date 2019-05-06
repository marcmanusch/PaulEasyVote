$(document).ready(function() {
    $('#paulVoting').change(function(){

        url = $('#paulVoting').attr('data-ajaxUrl');

        var votingCheck = $(this).find("option:selected").attr('value');

        $.post( url, { votingCheck: votingCheck }, function( data ) {
            $.loadingIndicator.close();
        });
    });
});