$(document).ready(function() {
    $('#paulVoting').change(function(){

        url = $('#paulVoting').attr('data-ajaxUrl');

        var votingCheck = $('#paulVoting:checked').val();

        if (votingCheck == 'on') {
            votingCheck = 1;
        } else {
            votingCheck = 0;
        }

        $.post( url, { votingCheck: votingCheck }, function( data ) {
            $.loadingIndicator.close();
        });
    });
});