
$(document).ready(function(){

    var $vote = $('#vote');

    $('.vote_star', $vote).click(function(e){
        e.preventDefault();
        var urlRoute = Routing.generate('artwork_show', {id: 'id'});
        vote($(this).data('score'), urlRoute)
    });

    function vote(value, url){

        $('.vote_loading', $vote).show();

        $.post(url, {
            ref: $vote.data('ref'),
            ref_id: $vote.data('ref_id'),
            vote: value
        }).done(function(data, textStatus, jqXHR){
            $('#dislike_count').text(data.dislike_count);
            $('#like_count').text(data.like_count);
            $vote.removeClass('is-liked is-disliked is-score1 is-score2 is-score3 is-score4 is-score5');
            if(data.success){
                if(data.score){
                    // On vote
                    $vote.addClass('is-score' + Math.round(data.score));
                }
            }
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            alert(jqXHR.responseText);
        }).always(function(){
            $('.vote_loading', $vote).hide();
            $('.vote_btns', $vote).fadeIn();
        });
    }

})