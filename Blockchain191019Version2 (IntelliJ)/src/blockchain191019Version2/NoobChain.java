package blockchain191019Version2;

import com.google.gson.Gson;
import com.itextpdf.text.Document;
import com.itextpdf.text.DocumentException;
import com.itextpdf.text.PageSize;
import com.itextpdf.text.Paragraph;
import com.itextpdf.text.pdf.PdfWriter;

import java.io.ByteArrayOutputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.PrintStream;
import java.sql.*;
import java.util.*;


public class NoobChain {

    public static HashMap<String, BlockChain> blockChainList = new HashMap<>(); //create a blockchainlist and store all the blockchain in list
    public static String finalStatus = "cannot sale"; // vehicle status

    public static void main(String[] args) {
        // get data from db
        HashMap<String, ContractLists> details = getDetails();

        // check if database is empty
        if (details.isEmpty()) {

            System.out.println("The database is empty.");
            System.out.println("Please go to Trusted Dealer website to create some data.");

        } else {
            //everytime rerun system again, it will clean phpmyadmin (odometer and vehicle status = NULL)
            try {
                Class.forName("com.mysql.cj.jdbc.Driver");
                Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blockchain_database?useTimezone=true&serverTimezone=UTC", "root", "");
                Statement stmt = con.createStatement();
                stmt.executeUpdate("UPDATE vehicle_details SET vehicle_details.odometer = NULL, vehicle_details.status = NULL WHERE vehicle_details.vin");

                // clean contracts and owner_details
                Statement stmt1 = con.createStatement();
                stmt1.executeUpdate("DELETE contracts, owner_details FROM contracts INNER JOIN owner_details ON contracts.nric = owner_details.nric WHERE contracts.seller_nric <> 'null'");

                con.close();
            } catch (ClassNotFoundException | SQLException e) {
                e.printStackTrace();
            }

            // insert into blockchain
            System.out.println("Importing data from database...");
            for (String i : details.keySet()) {

                // check if the vin is exist in the blockchain
                if (blockChainList.containsKey(i)) {
                    blockChainList.get(i).addBlock(details.get(i).toJson());
                } else {
                    // create a new blockchain
                    blockChainList.put(i, new BlockChain());
                    blockChainList.get(i).addBlock(details.get(i).toJson());
                }

            }
            System.out.println("Import complete.");

            int selection;
            Scanner sc = new Scanner(System.in);

            do {
                System.out.println("\n----------Menu----------");
                System.out.println("1 - Create New Blockchain");
                System.out.println("2 - Add a Block");
                System.out.println("3 - View all BlockChain");
                System.out.println("4 - View one BlockChain");
                System.out.println("5 - Validate BlockChain");
                System.out.println("6 - Generate Installment Records");
                System.out.println("7 - Sync Contract");
                System.out.println("0 - Quit [Generate pdf]");

                // input mismatch error prevention
                do {
                    selection = 999;

                    try {
                        // get input selection
                        selection = sc.nextInt();
                        sc.nextLine(); // throw away the \n not consumed by nextInt()
                    } catch (InputMismatchException e) {
                        System.out.println("Invalid selection number! Please try again!");
                        sc.nextLine(); // throw away the \n not consumed by nextInt()
                    }
                } while (selection == 999);

                if (selection == 1) {
                    System.out.println("Enter a new key: ");
                    String input_key = sc.nextLine();
                    if (blockChainList.containsKey(input_key)) {
                        System.out.println("Duplicate key !");
                    } else {
                        blockChainList.put(input_key, new BlockChain());
                    }

                } else if (selection == 2) {
                    // print key list
                    System.out.println("Vin List: ");
                    for (String i : blockChainList.keySet()) {
                        System.out.println("Vin: " + i);
                    }

                    System.out.println("\nEnter a vin: ");
                    String input_vin = sc.nextLine();

                    // if blockchainlist contain vin
                    if (blockChainList.containsKey(input_vin)) {
                        OdometerReading odometer = new OdometerReading(blockChainList.get(input_vin));
                        Installment installment = new Installment(blockChainList.get(input_vin));

                        HashMap<String, Integer> hm = new HashMap<>();
                        hm.put("odometer", odometer.calculateOdometer());

                        // check if have car loan
                        if (installment.getInstallmentAmount(input_vin).containsValue(0)) { // no car loan
                            // System.out.println("Debug testing:: no car loan");
                            System.out.println("Current Block Odometer:" + odometer.getOdometer());
                            System.out.println("Debug testing:: This vehicle no car loan. Can SELL !");

                            // hm.put("odometer", odometer.calculateOdometer());

                            // add new block
                            blockChainList.get(input_vin).addBlock(new Gson().toJson(hm));

                            int finalOdometer = odometer.getOdometer();
                            finalStatus = "can sale";

                            // update odometer and vehicle status into database
                            try {
                                Class.forName("com.mysql.cj.jdbc.Driver");
                                Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blockchain_database?useTimezone=true&serverTimezone=UTC", "root", "");
                                Statement stmt = con.createStatement();
                                Statement stmt_1 = con.createStatement();
                                stmt.executeUpdate("UPDATE vehicle_details SET vehicle_details.odometer = " + finalOdometer + " WHERE vehicle_details.vin = " + input_vin);
                                stmt_1.executeUpdate("UPDATE vehicle_details SET vehicle_details.status = '" + finalStatus + "' WHERE vehicle_details.vin = '" + input_vin + "'");

                                con.close();
                            } catch (ClassNotFoundException | SQLException e) {
                                e.printStackTrace();
                            }

                        } else { //installment got value means got car loan
                            hm.put("Monthly Installment Status", installment.randInstallmentTF());
                            blockChainList.get(input_vin).addBlock(new Gson().toJson(hm));
                            int countTrueInstallment = installment.countInstallment();

//                        System.out.println("Debug get overyear::" + installment.getOveryear(input_nric));
//                        System.out.println("Debug count Installment:: " + countTrueInstallment);
                            System.out.println("Current Block Odometer:" + odometer.getOdometer());

                            // when the overyear equal count true installment, means can sell
                            if (installment.getOveryear(input_vin) == countTrueInstallment) {

                                System.out.println("Debug testing:: This vehicle done of the payment. Can SELL !");

                                int finalOdometer = odometer.getOdometer();
                                finalStatus = "can sale";

                                // update odometer and vehicle status into database
                                try {
                                    Class.forName("com.mysql.cj.jdbc.Driver");
                                    Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blockchain_database?useTimezone=true&serverTimezone=UTC", "root", "");
                                    Statement stmt = con.createStatement();
                                    Statement stmt_1 = con.createStatement();
                                    stmt.executeUpdate("UPDATE vehicle_details SET vehicle_details.odometer = " + finalOdometer + " WHERE vehicle_details.vin = " + input_vin);
                                    stmt_1.executeUpdate("UPDATE vehicle_details SET vehicle_details.status = '" + finalStatus + "' WHERE vehicle_details.vin = '" + input_vin + "'");

                                    con.close();
                                } catch (ClassNotFoundException | SQLException e) {
                                    e.printStackTrace();
                                }
                            }
                        }

                    } else {
                        System.out.println("Invalid vin !");
                    }

                } else if (selection == 3) {
                    // loop the blockchainlist and display all
                    for (String i : blockChainList.keySet()) {
                        System.out.println("\nBlockChain: " + i);
                        blockChainList.get(i).viewBlockChain();
                    }

                } else if (selection == 4) {
                    // print key list
                    System.out.println("Vin List: ");
                    for (String i : blockChainList.keySet()) {
                        System.out.println("Vin: " + i);
                    }

                    System.out.println("\nEnter a vin: ");
                    String input_vin = sc.nextLine();

                    // if blockchainlist contain vin
                    if (blockChainList.containsKey(input_vin)) {
                        blockChainList.get(input_vin).viewBlockChain();
                    } else {
                        System.out.println("Invalid vin !");
                    }

                } else if (selection == 5) {
                    for (String i : blockChainList.keySet()) {
                        System.out.println("\nChecking BlockChain: " + i);
                        blockChainList.get(i).checkChainValid();
                    }

                } else if (selection == 6) {
                    // print key list
                    System.out.println("Vin List: ");
                    for (String i : blockChainList.keySet()) {
                        System.out.println("Vin: " + i);
                    }

                    // get input
                    System.out.println("\nEnter a vin: ");
                    String input_vin = sc.nextLine();

                    if (blockChainList.containsKey(input_vin)) {
                        OdometerReading odometer = new OdometerReading(blockChainList.get(input_vin));
                        Installment installment = new Installment(blockChainList.get(input_vin));
                        HashMap<String, Integer> hm = new HashMap<>();

                        // check if have car loan
                        if (installment.getInstallmentAmount(input_vin).containsValue(0)) {
                            // no car loan
                            System.out.println("Debug testing:: This vehicle no car loan. Can SELL !");
                            System.out.println("You can select the number 2 to add a block.");

                        } else { //have car loan

                            // check if car loan done
                            if (installment.countInstallment() == installment.getOveryear(input_vin)) { // car loan done payment
                                System.out.println("Debug testing:: This vehicle done of the payment. Can SELL !");
                                System.out.println("You can select the number 2 to add a block.");
                            }

                            // auto generate the block (odometer and installment) till the installment (1) reach the overyear
                            while (installment.countInstallment() < installment.getOveryear(input_vin)) {

                                hm.put("odometer", odometer.calculateOdometer());
                                hm.put("Monthly Installment Status", installment.randInstallmentTF());

                                // add new block
                                blockChainList.get(input_vin).addBlock(new Gson().toJson(hm));

                                int countTrueInstallment = installment.countInstallment();

                                // when the overyear equal count true installment, means can sell
                                if (installment.getOveryear(input_vin) == countTrueInstallment) {

                                    System.out.println("Current Block Odometer:" + odometer.getOdometer());
                                    System.out.println("Debug testing:: This vehicle done of the payment. Can SELL !");

                                    int finalOdometer = odometer.getOdometer();
                                    finalStatus = "can sale";

                                    // update odometer and vehicle status into database
                                    try {
                                        Class.forName("com.mysql.cj.jdbc.Driver");
                                        Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blockchain_database?useTimezone=true&serverTimezone=UTC", "root", "");
                                        Statement stmt = con.createStatement();
                                        Statement stmt_1 = con.createStatement();
                                        stmt.executeUpdate("UPDATE vehicle_details SET vehicle_details.odometer = '" + finalOdometer + "' WHERE vehicle_details.vin = '" + input_vin + "'");
                                        stmt_1.executeUpdate("UPDATE vehicle_details SET vehicle_details.status = '" + finalStatus + "' WHERE vehicle_details.vin = '" + input_vin + "'");

                                        con.close();
                                    } catch (ClassNotFoundException | SQLException e) {
                                        e.printStackTrace();
                                    }
                                }
                            }
                        }
                    }
                } else if (selection == 7) {
                    // sync contract
                    System.out.println("Syncing contract...");
                    try {
                        Class.forName("com.mysql.cj.jdbc.Driver");
                        Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blockchain_database?useTimezone=true&serverTimezone=UTC", "root", "");
                        Statement stmt = con.createStatement();
                        ResultSet rs = stmt.executeQuery("SELECT owner_details.*, vehicle_details.*, contracts.* " +
                                "FROM contracts " +
                                "INNER JOIN owner_details ON contracts.nric = owner_details.nric " +
                                "INNER JOIN vehicle_details ON contracts.vin = vehicle_details.vin " +
                                "ORDER BY contractid ASC");

                        while (rs.next()) {
                            String contractId = rs.getString("contractid");
                            String vin = rs.getString("vin");

                            // create a temporary ContractList in advance to reduce duplicate code
                            String fname = rs.getString("fname");
                            String lname = rs.getString("lname");
                            String nric = rs.getString("nric");
                            String pnumber = rs.getString("pnumber");
                            String epf = rs.getString("epf");
                            String annual = rs.getString("annual");
                            String payslip = rs.getString("payslip");
                            String brand = rs.getString("brand");
                            String model = rs.getString("model");
                            String colour = rs.getString("colour");
                            int price = rs.getInt("price");
                            String bank = rs.getString("bank");
                            int borrowamount = rs.getInt("borrowamount");
                            int overyear = rs.getInt("overyear");
                            int installment = rs.getInt("installment");
                            String signa = rs.getString("signa");
                            String dateapply = rs.getString("dateapply");
                            int odometer = rs.getInt("odometer");

                            ContractLists ncd = new ContractLists(Integer.parseInt(contractId), vin, fname, lname, nric, pnumber, epf, annual,
                                    payslip, brand, model, colour, price, odometer, bank, borrowamount, overyear, installment,
                                    signa, dateapply);

                            // check if the VIN exist in the BlockChain
                            if (blockChainList.containsKey(vin)) {
                                // VIN exist in the BlockChain, check if contractId exist

                                // get the BlockChain
                                BlockChain bc = blockChainList.get(vin);
                                Contract contract = new Contract(bc);

                                // if contractId not exist, add it into the BlockChain
                                if (!contract.isContractExist(Integer.parseInt(contractId))) {

                                    // add contract to BlockChain
                                    bc.addBlock(ncd.toJson());
                                    System.out.println("New contract added! #" + contractId);
                                }
                            } else {
                                // VIN not exist, create a new BlockChain
                                blockChainList.put(vin, new BlockChain());

                                // add contract to BlockChain
                                blockChainList.get(vin).addBlock(ncd.toJson());
                                System.out.println("New contract added! #" + contractId);
                            }
                        }

                        System.out.println("Syncing Completed!");

                        con.close();
                    } catch (ClassNotFoundException | SQLException e) {
                        e.printStackTrace();
                    }

                } else {
                    if (selection != 0) {
                        System.out.println("Invalid selection number! Please try again!");

                        // reset selection to 999
                        selection = 999;
                    }
                }

                // reset selection to 999
                //selection = 999;

            } while (selection != 0);


            //while enter 0, generate pdf
            try {
                ByteArrayOutputStream file = new ByteArrayOutputStream();
                System.setOut(new PrintStream(file));

                for (String i : blockChainList.keySet()) {
                    System.out.println("\nBlockChain: " + i);
                    blockChainList.get(i).viewBlockChain();
                }

                Document document = new Document(PageSize.A4, 30, 30, 30, 30);
                PdfWriter.getInstance(document, new FileOutputStream("finaloutput.pdf"));
                document.open();
                document.add(new Paragraph(file.toString()));
                document.close();
                file.close();
            } catch (IOException | DocumentException e) {
                e.printStackTrace();
            }
        }
    }

    // get details from blockchain_database
    public static HashMap<String, ContractLists> getDetails() {
        HashMap<String, ContractLists> map = new HashMap<>();

        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blockchain_database?useTimezone=true&serverTimezone=UTC", "root", "");
            Statement stmt = con.createStatement();
            ResultSet rs = stmt.executeQuery("SELECT owner_details.*, vehicle_details.*, contracts.*\n" +
                    "FROM contracts\n" +
                    "INNER JOIN owner_details ON contracts.nric=owner_details.nric\n" +
                    "INNER JOIN vehicle_details ON contracts.vin=vehicle_details.vin");

            while (rs.next()) {
                int contractId = rs.getInt("contractid");
                String fname = rs.getString("fname");
                String lname = rs.getString("lname");
                String nric = rs.getString("nric");
                String pnumber = rs.getString("pnumber");
                String epf = rs.getString("epf");
                String annual = rs.getString("annual");
                String payslip = rs.getString("payslip");
                String brand = rs.getString("brand");
                String model = rs.getString("model");
                String colour = rs.getString("colour");
                int price = rs.getInt("price");
                String bank = rs.getString("bank");
                int borrowamount = rs.getInt("borrowamount");
                int overyear = rs.getInt("overyear");
                int installment = rs.getInt("installment");
                String signa = rs.getString("signa");
                String dateapply = rs.getString("dateapply");
                String vin = rs.getString("vin");
                int odometer = rs.getInt("odometer");

                ContractLists ncd = new ContractLists(contractId, vin, fname, lname, nric, pnumber, epf, annual, payslip, brand, model, colour, price, odometer, bank, borrowamount, overyear, installment, signa, dateapply);
                map.put(vin, ncd);
            }
        } catch (SQLException e) {
            System.out.println(e.getMessage());
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        }
        return map;
    }
}