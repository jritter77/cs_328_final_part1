import { post } from "./WebRequest.js";

const submit = $("input[type=submit]");
submit.click(submitForm);

async function submitForm(e) {
  let form = document.querySelector("form");
  let isValid = form.checkValidity();

  if (!isValid) {
    form.reportValidity();
  } else {
    e.preventDefault();
    let inputs = $("input[type!=submit]");

    let submission = {};

    for (let i of inputs) {
      if (i.type !== "radio") {
        submission[i.name] = i.value;
      } else {
        if (i.checked) {
          submission[i.name] = i.value;
        }
      }
    }

    console.log(submission);
    let response = await post(
      "../../server/new_prop.php",
      JSON.stringify(submission)
    );
    alert("Property added!");
    form.reset();
  }
}
