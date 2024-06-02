// invoice.js
document.addEventListener("DOMContentLoaded", function () {
    const generateInvoiceButton = document.getElementById("generateInvoiceButton");
    const invoiceForm = document.getElementById("invoiceForm");
    const invoiceBill = document.getElementById("invoiceBill");

    generateInvoiceButton.addEventListener("click", function () {
        const patientName = document.getElementById("patientName").value;
        const date = document.getElementById("date").value;
        const roomCharges = document.getElementById("roomCharges").value;
        const medicines = document.getElementById("medicines").value;

        // Generate the invoice HTML
        const invoiceHTML = `
            <h2>Invoice for ${patientName}</h2>
            <p>Date: ${date}</p>
            <p>Room Charges: $${roomCharges}</p>
            <p>Medicines: ${medicines}</p>
            <p>Total Amount: $${parseInt(roomCharges) + 0}</p>
        `;

        // Display the invoice and hide the form
        invoiceForm.style.display = "none";
        invoiceBill.style.display = "block";
        invoiceBill.innerHTML = invoiceHTML;
    });
});
