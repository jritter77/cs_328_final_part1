import { post } from "./WebRequest.js";

const submit = $("input[type=submit]");
submit.click(submitForm);

async function submitForm(e) {
  let form = document.querySelector("form");
  let isValid = form.checkValidity();

  if (false) {
    form.reportValidity();
  } else {
    e.preventDefault();
    let inputs = $("input[type!=submit]");

    let sub = {};

    for (let i of inputs) {
      if (i.type !== "radio") {
        sub[i.name] = i.value;
      } else {
        if (i.checked) {
          sub[i.name] = i.value;
        }
      }
    }

    console.log(sub);
    let response = await post("./submission.php", JSON.stringify(sub));
    console.log(response);
  }
}
