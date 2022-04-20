import { get, post } from "./WebRequest.js";

const months = [
  "JAN",
  "FEB",
  "MAR",
  "APR",
  "MAY",
  "JUN",
  "JUL",
  "AUG",
  "SEP",
  "OCT",
  "NOV",
  "DEC",
];

async function getProps() {
  let result = await get("../../server/getAllProps.php");
  console.log(result);
  return JSON.parse(result);
}

async function getPropsByDate(startDate, endDate) {
  let result = await post(
    "../../server/getPropsForPeriod.php",
    JSON.stringify({ start_date: startDate, end_date: endDate })
  );
  console.log(result);
  return JSON.parse(result);
}

function convertDate(dateStr) {
  let dateArr = dateStr.split("-");
  let year = dateArr[0].substr(2);
  let month = months[parseInt(dateArr[1]) - 1];
  let day = dateArr[2];

  return `${day}-${month}-${year}`;
}

async function populateTable(e) {
  let startDate = $("#start_date");
  let endDate = $("#end_date");

  console.log(convertDate(startDate.val()));

  let props = await getPropsByDate();
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

$("#submit_btn").click(populateTable);
