import { get } from "./WebRequest.js";

async function getProps() {
  let result = await get("../../server/getAllProps.php");
  console.log(result);
  return JSON.parse(result);
}

async function populateTable() {}

getProps();
