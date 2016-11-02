"use strict";
var bidHistory = [];
var bidIndexes = [];

$(".bid_card, .call_card").click(function(e){
    e.preventDefault();

    if($(this).hasClass("disabled")){
        return false;
    }

    bidHistory.push($(this).data("bid-string"));
    var cardIndex = 1 + $(".bid_card").index($(this));

    if($(this).hasClass('bid_card')) {
        bidIndexes.push(cardIndex);
    }

    $( ".bid_card:lt(" + cardIndex  + ")" ).addClass("disabled");

    if (canDouble()) {
        $(".double").removeClass("disabled");
    }else{
        $(".double").addClass("disabled");
    }

    if (canRedouble()) {
        $(".redouble").removeClass("disabled");
    }else{
        $(".redouble").addClass("disabled");
    }

    if(bidHistory.length > 0){
        $(".undo_button .button").removeClass("is-disabled");
    }

    updateBiddingTable();
    updateBiddingData();

    return false;
});

$("#undo").click(function(){
    if(!bidHistory.length){
         // "Nothing to undo"
        return;
    }

    var removedBid = bidHistory.pop();

    removeAlerted(removedBid);

    if(removedBid != 'P' || removedBid != 'X' || removedBid != 'XX') {
        bidIndexes.pop();
        var revertIndex = bidIndexes.length > 1 ? (bidIndexes[bidIndexes.length  -1 ]) -1 : 0;
        if(revertIndex){
            $(".bid_card:gt(" + revertIndex  + ")" ).removeClass("disabled");
        }else{
            $(".bid_card").removeClass("disabled");
        }
    }

    if (canDouble()) {
        $(".double").removeClass("disabled");
    }else{
        $(".double").addClass("disabled");
    }

    if (canRedouble()) {
        $(".redouble").removeClass("disabled");
    }else{
        $(".redouble").addClass("disabled");
    }

    updateBiddingTable();
    updateBiddingData();

    if(bidHistory.length == 0){
        $(".undo_button .button").addClass("is-disabled");
    }
});

$("#vul").change(function(){
    $(".diagram-header").removeClass("none n s all").addClass($(this).val());
});

// show alert box
$("#bidding-diagram .bidding").on('click', "div", function(e){
    e.preventDefault();

    var $inputDiv = $("#explain_bid");
    var $inputField = $("#explain_bid_input");
    var bid = $(this).text();

    $inputDiv.show().focus();
    $inputDiv.find("label span").text("(" + bid + ")");
    $inputField.val(''); // clear input field
    $inputField.data("bid", bid );

    /*console.log( $( this ).text() );*/
});

$("#save_alert").click(function(){
    var elExplanation =  $("#explain_bid_input");
    var explanation = elExplanation.val();
    var elForm = elExplanation.parents("form");
    var elAlerts = $("#alerts");

    if(!explanation.trim()){
        return false;
    }

    // Put alerts into an array of hidden input boxes;

    elForm.append("<input name='alert[" + elExplanation.data("bid") + "]' type='hidden' value='" + explanation + "'>");
    var insert = $("<div id='alert-" + elExplanation.data("bid") + "'><strong>"+elExplanation.data("bid") + ": </strong> <span></span></div>");

    console.log(insert);
    insert.find("span").text(explanation);
    insert.appendTo(elAlerts);

    // empty box and hide alert form elements
    elExplanation.val('');
    $("#explain_bid").hide();
});

$("#cancel_alert").click(function(e){
    e.preventDefault();
    $("#explain_bid").hide();
    $("#explain_bid_input").val('');
});

$("#appeal_form").submit(function(){
    $("#bidding-data").val(bidHistory.join(' '));
});

// remove alerted bid
function removeAlerted(bid){
    var alerted = $("input[name=alert\\[" + bid +"\\]]");
    if(alerted.length){
        alerted.remove();
    }
}

function updateBiddingData(){
    $("#bidding").val(bidHistory.join(' '));
}

function getDealer(){
    return $("#dealer").val();
}

function updateBiddingTable(){
    var elBidding = $(".bidding-diagram #bidding");

    elBidding.empty();

    for(var i = 0; i < getDealer(); i++){
        elBidding.append("<div>&nbsp;</div>");
    }

    bidHistory.forEach(function(bid, index){
        elBidding.append("<div data-index='" + index + "'>"+bid+"</div>");
    });
}

function canDouble(){
    if(!bidHistory.length) return false;

    var previousBid = bidHistory[bidHistory.length - 1];

    if (previousBid == 'X' || previousBid == 'XX') {
        return false;
    }

    if(previousBid != 'P'){
        return true;
    }

    if (previousBid == 'P' && bidHistory[bidHistory.length - 2] == 'P') {
        if(bidHistory.length < 4 && bidHistory[0] == 'P') return false;

        if (bidHistory[bidHistory.length - 3] == 'X') {
            return false;
        }
        return true
    }

    return false;
}

function canRedouble(){
    var previousBid = bidHistory[bidHistory.length - 1];

    if (previousBid == 'X') {
        return true;
    }

    if(previousBid == 'P' && bidHistory[bidHistory.length - 3] == 'X'){
        return true;
    }

    return false;
}