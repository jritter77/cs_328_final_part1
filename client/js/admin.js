import { get } from "./WebRequest.js";

async function getProps() {
  let result = await get("../../server/getAllProps.php");
  console.log(result);
  return JSON.parse(result);
}

async function populateTable() {
  let props = await getProps();
  let table = $("#props_table");

  table.html("");

  table.append(`
    <th>Sumbiission Date</th>
    <th>Seller Name</th>
    <th>Seller Phone</th>
    <th>Seller Address</th>
    <th>Building Name</th>
    <th>Building Price</th>
    <th>Building Address</th>
    <th>Area</th>
    <th>Type</th>
    <th>SQFT</th>
    <th>Height</th>
    <th>Rooms</th>
    <th>Floors</th>
    <th>Year Built</th>
  `);

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
