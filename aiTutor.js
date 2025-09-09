function loadPage() {
    loadLevelDescriptions();
}

function loadLevelDescriptions() {
    const URL = "http://172.17.15.182/final.php/getLevelDes";

    $.ajax({
        type: "GET",
        contentType: "application/json",
        url: URL,
        cache: false,
        timeout: 60000,
        success: function (data) {
            console.log("SUCCESS:", data);

            if (data.status === 0) {
                populateLevels(data.result);
            } else {
                alert("Error loading levels: " + data.message);
            }
        },
        error: function (e) {
            console.error("ERROR:", e);
            alert("Failed to fetch levels. Please try again later.");
        }
    });
}

function populateLevels(levels) {
    const dropdown = $("#user-level");
    dropdown.empty();
    dropdown.append('<option value="none">Select Level</option>');

    levels.forEach(level => {
        dropdown.append(
            `<option value="${level.description}">${level.description}</option>`
        );
    });
}

$(document).ready(function () {
    $("#send-btn").click(function () {
        const userLevel = $("#user-level").val();
        const userInput = $("#user-input").val();

        if (userLevel === "none") {
            alert("Please select a user level!");
            return;
        }

        if (userInput.trim() === "") {
            alert("Please type a question!");
            return;
        }

        $('#chat-window').append(`<p><strong>You:</strong> ${userInput}</p>`);

        $.ajax({
            url: "http://172.17.15.182/final.php/chatGPTInteraction",
            type: "POST",
            data: {
                description: userLevel,
                question: userInput,
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 0 && response.output) {
                    $('#chat-window').append(`<p><strong>AI:</strong> ${response.output}</p>`);
                    $('#chat-window').scrollTop($('#chat-window')[0].scrollHeight);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                alert('An error occurred. Please try again.');
            },
        });

        $("#user-input").val("");
    });
});
