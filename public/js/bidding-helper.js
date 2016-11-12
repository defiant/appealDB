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

    // Bid indexes is used to keep record for undos but only suit bids
    if($(this).hasClass('bid_card')) {
        bidIndexes.push(cardIndex);
    }

    // if we have 3 passes auction ended, disable all bidding cards
    if(bidHistory.slice(-3).equals(['P', 'P', 'P']) && bidHistory.length > 3){
        $(".bid_card, .call_card").addClass("disabled");
    }else{
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

    $(".pass").removeClass("disabled");

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

// write out bidding data when submitting
$("#appeal_form").submit(function(){
    $("#bidding-data").val(bidHistory.join(' '));
});

// Allow only valid chars
$(".hand-input input").keyup(function (e) {
    var validChars = ['a', 'k', 'q', 'j', 't', 'x'];
    var char = $(this).val().substr(-1);

    if(validChars.indexOf(char.toLowerCase()) == -1){
        if(parseInt(char) > 1 && parseInt(char) < 10){
            return;
        }
        $(this).val($(this).val().slice(0, -1));
    }
});

// Remove duplicates check hand sizes
$(".hand-input input").blur(function(){
    function dup(x, n, s){
        if(x == 'x' || x == 'X') {
            return true;
        }

        return s.indexOf(x) == n;
    }

    var newVal = $(this).val().split("").filter(dup).join("");
    $(this).val(newVal);


    var parent = $(this).parent();

    if(getLen(parent.find("input")) > 13){
        parent.addClass("is-error");
        $("#too_many_cards").show();
        $("#submit").prop( "disabled", true).addClass('is-disabled');
    }else{
        parent.removeClass("is-error");
        $("#too_many_cards").hide();
        $("#submit").prop( "disabled", false).removeClass('is-disabled');
    }
});

$("button.delete").click(function(){
    $(this).parent().fadeOut(300);
});

function getLen(o){
    var i = 0;
    o.each(function () {
            i += $(this).val().length;
        }
    );
    return i;
}

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


// Utility function for comparing arrays
// Warn if overriding existing method
if(Array.prototype.equals)
    console.warn("Overriding existing Array.prototype.equals. Possible causes: New API defines the method, there's a framework conflict or you've got double inclusions in your code.");
// attach the .equals method to Array's prototype to call it on any array
Array.prototype.equals = function (array) {
    // if the other array is a falsy value, return
    if (!array)
        return false;

    // compare lengths - can save a lot of time
    if (this.length != array.length)
        return false;

    for (var i = 0, l=this.length; i < l; i++) {
        // Check if we have nested arrays
        if (this[i] instanceof Array && array[i] instanceof Array) {
            // recurse into the nested arrays
            if (!this[i].equals(array[i]))
                return false;
        }
        else if (this[i] != array[i]) {
            // Warning - two different object instances will never be equal: {x:20} != {x:20}
            return false;
        }
    }
    return true;
}
// Hide method from for-in loops
Object.defineProperty(Array.prototype, "equals", {enumerable: false});