const autoCompleteJS = new autoComplete({
    selector: "#autoComplete",
    placeHolder: "Search Country Code",
    data: {
        src: [
            "+93 - Fabio",
            "+358 - Aland Islands"
        ],
        cache: true,
    },
    resultsList: {
        element: (list, data) => {
            if (!data.results.length) {
                // Create "No Results" message element
                const message = document.createElement("div");
                // Add class to the created element
                message.setAttribute("class", "no_result");
                // Add message text content
                message.innerHTML = `<span>Found No Results for "${data.query}"</span>`;
                // Append message element to the results list
                list.prepend(message);
            }
        },
        noResults: true,
    },
    resultItem: {
        highlight: {
            render: true
        }
    },
    events: {
        input: {
          focus() {
            if (autoCompleteJS.input.value.length) autoCompleteJS.start();
          },
          selection(event) {
            const feedback = event.detail;
            // Prepare User's Selected Value
            const selection = feedback.selection.value;
            // Replace Input value with the selected value
            autoCompleteJS.input.value = selection;
          },
        },
    },
});





const example2 = new autoComplete({
    selector: "#example2",
    placeHolder: "Enter Country Code",
    data: {
        src: [
            "+93 - Fabio",
            "+358 - Aland Islands"
        ],
        cache: true,
    },
    resultsList: {
        element: (list, data) => {
            if (!data.results.length) {
                // Create "No Results" message element
                const message = document.createElement("div");
                // Add class to the created element
                message.setAttribute("class", "no_result");
                // Add message text content
                message.innerHTML = `<span>Found No Results for "${data.query}"</span>`;
                // Append message element to the results list
                list.prepend(message);
            }
        },
        noResults: true,
    },
    resultItem: {
        highlight: {
            render: true
        }
    },
    events: {
        input: {
          focus() {
            if (example2.input.value.length) example2.start();
          },
          selection(event) {
            const feedback = event.detail;
            // Prepare User's Selected Value
            const selection = feedback.selection.value;
            
            // Replace Input value with the selected value
            example2.input.value = selection;
          },
        },
    },
});