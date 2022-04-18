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
    let row = $("<tr></tr>");

    for (let col in prop) {
      let c = `<td>${prop[col]}</td>`;
      row.append(c);
    }

    table.append(row);
  }
}

populateTable();
