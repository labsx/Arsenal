import JsBarcode from "jsbarcode";

const generateBarcode = (barcodeValue) => {
  const canvas = document.createElement("canvas");
  JsBarcode(canvas, barcodeValue, {
    format: "CODE128",
    displayValue: true,
  });
  return canvas.toDataURL();
};

export const printHistory = (items, formatDate) => {
    const tableContent = `
      <table border="1">
        <thead>
          <tr>
            <th>Item Name</th>
            <th>Serial</th>
            <th>Date Issued</th>
            <th>Date Return</th>
            <th>Issued To</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          ${items
            .map(
                (item) => `
            <tr>
              <td>${item.name}</td>
              <td>${item.serial}</td>
              <td>${formatDate(item.date_issued)}</td>
              <td>${formatDate(item.return_date)}</td>
              <td>${item.issued_to}</td>
              <td>${item.status}</td>
            </tr>
          `
            )
            .join("")}
        </tbody>
      </table>
    `;

    const printWindow = window.open("", "_blank");
    printWindow.document.write(`
      <html>
        <head>
          <title>Print History</title>
          <style>
            table {
              width: 100%;
              border-collapse: collapse;
              margin-bottom: 10px;
              font-family: sans-serif;
            }
  
            th, td {
              border: 1px solid #ccc;
              padding: 8px;
              text-align: left;
            }
  
            th {
              background-color: #f0f0f0;
            }
            h1{
              font-family: sans-serif;
              text-align: center;
            }
          </style>
        </head>
        <body>
          <h1>List of items issued</h1>
          ${tableContent}
        </body>
      </html>
    `);

    printWindow.onload = function () {
        printWindow.print();
        printWindow.onafterprint = function () {
            printWindow.close();
        };
    };
};

export const printItemsData = (items, formatDate) => {
    const tableContent = `
      <table border="1">
        <thead>
          <tr>
            <th>Item Name</th>
            <th>Serial</th>
            <th>Status</th>
            <th>Date Store</th>
            <th>Barcode</th>

           
          </tr>
        </thead>
        <tbody>
          ${items
            .map(
                (item) => `
                <tr>
                  <td>${item.name}</td>
                  <td>${item.serial}</td>
                  <td>${item.status}</td>
                  <td>${formatDate(item.created_at)}</td>
                  <td> 
                  <div class="barcode">
                  <img src="${generateBarcode(item.barcode)}" alt="Barcode" style="height: 50px"/>
                </div></td>
                </tr>
              `
            )
            .join("")}
        </tbody>
      </table>
    `;

    const printWindow = window.open("", "_blank");
    printWindow.document.write(`
      <html>
        <head>
          <title>Print Items</title>
          <style>
            table {
              width: 100%;
              border-collapse: collapse;
              margin-bottom: 10px;
              font-family: sans-serif;
            }
            th, td {
              border: 1px solid #ccc;
              padding: 8px;
              text-align: left;
            }
            th {
              background-color: #f0f0f0;
            }
            h1 {
              text-align: center;
              font-family: sans-serif;
            }
          </style>
        </head>
        <body>
          <h1>List of Items</h1>
          ${tableContent}
        </body>
      </html>
    `);

    printWindow.onload = function () {
        printWindow.print();
        printWindow.onafterprint = function () {
            printWindow.close();
        };
    };
};
