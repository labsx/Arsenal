export const printHistory = (items, formatDate) => {
    const tableContent = `
      <table border="1">
        <thead>
          <tr>
            <th>Item Name</th>
            <th>Serial</th>
            <th>Model</th>
            <th>Issued Item</th>
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
              <td>${item.model}</td>
              <td>${item.count}</td>
              <td>${formatDate(item.issued_date)}</td>
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
            <th>Items Available</th>
            <th>Items Issued</th>
            <th>Serial</th>
            <th>Model</th>
            <th>Date</th>
            <th>Status</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          ${items
            .map(
                (item) => `
                <tr>
                  <td>${item.name}</td>
                  <td>${item.count}</td>
                  <td>${item.issued_item}</td>
                  <td>${item.serial}</td>
                  <td>${item.model}</td>
                  <td>${formatDate(item.date)}</td>
                  <td>${item.status}</td>
                  <td>${item.description}</td>
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
