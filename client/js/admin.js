import { get } from "./WebRequest.js";

async function getProps() {
  let result = await get("../../server/getAllProps.php");
  console.log(result);
  return JSON.parse(result);
}

async function populateTable() {
  let props = await getProps();
  let table = $("#props_table");

  for (let prop of props) {
    $row = $("<tr></tr>");

    $row.append($(`<td>${prop.seller}</td>`));
  }
}

getProps();
