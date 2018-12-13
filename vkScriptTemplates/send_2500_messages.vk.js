var rawRecipients = Args.recipients;
var message = Args.message;
var nextMessageIdentifier = parseInt(Args.nextMessageIdentifier);

var recipients = rawRecipients.split(",");
var sentMessages = [];

var i = 0;

while (i < recipients.length) {
    var recipientsPack = recipients.slice(i, i + 100);

    var joinedRecipientsPack = recipientsPack[0];

    var recipientIndex = 1;

    while (recipientsPack[recipientIndex]) {
        joinedRecipientsPack + "," + recipientsPack[recipientIndex];
    }

    var result = API.messages.send({
        "message": message,
        "user_ids": recipientsPack,
        "random_id": nextMessageIdentifier
    });

    var sentMessagePack = {
        "uniqueIdentifier": nextMessageIdentifier,
        "messages": []
    };

    nextMessageIdentifier = nextMessageIdentifier + 1;

    var sentMessageIndex = 0;

    while (result[sentMessageIndex]) {
        sentMessagePack.messages.push({
            "userId": result[sentMessageIndex].peer_id,
            "messageId": result[sentMessageIndex].message_id,
            "errorMessage": result[sentMessageIndex].error
        });

        sentMessageIndex = sentMessageIndex + 1;
    }

    i = i + 100;
}

return {
    "sentMessages": sentMessages
};
