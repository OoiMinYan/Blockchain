package blockchain191019Version2;

import com.google.gson.Gson;

import java.sql.Date;

public class ContractLists {
    private int contractid;
    private String vin;
    private String fname;
    private String lname;
    private String nric;
    private String pnumber;
    private String epf;
    private String annual;
    private String payslip;
    private String brand;
    private String model;
    private String colour;
    private int price;
    private int odometer;
    private String bank;
    private int borrowamount;
    private int overyear;
    private int installment;
    private String signa;
    private String dateapply;

    public ContractLists(int contractid, String vin, String fname, String lname, String nric, String pnumber, String epf, String annual, String payslip, String brand, String model, String colour, int price, int odometer, String bank, int borrowamount, int overyear, int installment, String signa, String dateapply) {
        this.contractid = contractid;
        this.vin = vin;
        this.fname = fname;
        this.lname = lname;
        this.nric = nric;
        this.pnumber = pnumber;
        this.epf = epf;
        this.annual = annual;
        this.payslip = payslip;
        this.brand = brand;
        this.model = model;
        this.colour = colour;
        this.price = price;
        this.odometer = odometer;
        this.bank = bank;
        this.borrowamount = borrowamount;
        this.overyear = overyear;
        this.installment = installment;
        this.signa = signa;
        this.dateapply = dateapply;
    }

    public int getContractid() {
        return this.contractid;
    }

    public String getVin() {
        return this.vin;
    }

    public String getFname() {
        return this.fname = fname;
    }

    public String getLname() {
        return this.lname = lname;
    }

    public String getNric() {
        return this.nric = nric;
    }

    public String getPnumber() {
        return this.pnumber = pnumber;
    }

    public String getEpf() {
        return this.epf = epf;
    }

    public String getAnnual() {
        return this.annual = annual;
    }

    public String getPayslip() {
        return this.payslip = payslip;
    }

    public String getBrand() {
        return this.brand = brand;
    }

    public String getModel() {
        return this.model = model;
    }

    public String getColour() {
        return this.colour = colour;
    }

    public int getPrice() {
        return this.price = price;
    }

    public int getOdometer() {
        return this.odometer = odometer;
    }

    public String getBank() {
        return this.bank = bank;
    }

    public int getBorrowamount() {
        return this.borrowamount = borrowamount;
    }

    public int getOveryear() {
        return this.overyear = overyear;
    }

    public int getInstallment() {
        return this.installment = installment;
    }

    public String getSigna() {
        return this.signa = signa;
    }

    public String getDateapply() {
        return this.dateapply = dateapply;
    }

    public String toString() {
        return this.contractid + "\n" +
                this.vin + "\n" +
                this.fname + "\n" +
                this.lname + "\n" +
                this.nric + "\n" +
                this.pnumber + "\n" +
                this.epf + "\n" +
                this.annual + "\n" +
                this.payslip + "\n" +
                this.brand + "\n" +
                this.model + "\n" +
                this.colour + "\n" +
                this.price + "\n" +
                this.odometer + "\n" +
                this.bank + "\n" +
                this.borrowamount + "\n" +
                this.overyear + "\n" +
                this.installment + "\n" +
                this.signa + "\n" +
                this.dateapply + "\n";
    }

    public String toJson() {
        Gson gson = new Gson();
        String json = gson.toJson(this);
        return json;
    }
}

