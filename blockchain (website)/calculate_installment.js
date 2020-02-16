function calculateInstallment() {
    // console.log("Hello Testing");
    var borrowamountValue = document.getElementById("borrowamount").value;
    var overyearValue = document.getElementById("overyear").value;

    var total = (borrowamountValue * 110 / 100) / (overyearValue * 12);
    var totalTwoDecimal = parseFloat(total).toFixed(2);

    document.getElementById("installment").value = totalTwoDecimal;
}