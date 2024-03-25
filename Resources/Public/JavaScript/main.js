
// $(document).ready(function() {
//     function submitForm() {
//         $.ajax({
//             type: "POST",
//             url: $('#simpleForm').attr('action'),
//             data: $('#simpleForm').serialize(),
//             success: function(response) {
//                 let jsonResponse = JSON.parse(response);
//                 $('#result').append('<div class="text-right">' + $('#userPrompt').val() + '</div>');
//                 $('#result').append('<div class="text-left" id="assistantAnswer" style="background-color: #feffb8; padding: 20px;"><p>' + jsonResponse.answer + '</p><button id="toggleCitation" data-citation="'+i+'" class="btn btn-info">File Citation</button></div>');
//                 $('#assistantAnswer').append('<div class="text-left" style="display: none;" id="fileCitation'+i+'"><p>' + jsonResponse.file_citation + '</p></div>');
                
//             },
//             error: function(xhr, status, error) {
//                 console.error("Error:", status, error);
//             }
//         });
//     }
//     $('#simpleForm').submit(function(event) {
//         event.preventDefault();
//         submitForm();
//     });
// });
