var rawRecipients = Args.recipients;
var recipients = rawRecipients.split(',');

if (recipients.length > 2500) {
    return {
        error: 'too many recipients (' + recipients.length + ')'
    };
}

var i = 0;
var unavailableRecipients = [];

while (recipients[i]) {
    var recipientsPack = [];

    if ()

    API.groups.approveRequest({
        group_id: group_id,
        user_id:  requests[i]
    });

    i = i + 1;
}

return i;
