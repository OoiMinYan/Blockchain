package blockchain191019Version2;

import java.lang.reflect.Type;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.HashMap;
import java.util.Map;
import java.util.Random;

import com.google.gson.Gson;
import com.google.gson.JsonSyntaxException;
import com.google.gson.reflect.TypeToken;

public class Installment {
    public static BlockChain blockchain = new BlockChain();
    private int installment;

    public Installment(BlockChain blockChain) {
        blockchain = blockChain;
    }

    public int countInstallment() {
        int count = 0;
        int checkInstallmentValue;

        // check every Block
        // blockchain.blockchain is the ArrayList in BlockChain class
        for (Block block : blockchain.blockchain) {
            String blockData = block.getData();

            // restore HashMap object from json string
            Map<String, String> map;
            Type type = new TypeToken<Map<String, String>>() {}.getType();
            try {
                map = new Gson().fromJson(blockData, type);

                // check installment value
                if (map.containsKey("Monthly Installment Status")) {
                    checkInstallmentValue = Integer.parseInt(map.get("Monthly Installment Status"));
                    //0 is no paid, 1 is paid
                    //if 1 then count the installment
                    if (checkInstallmentValue == 0) {
                        //System.out.println("Debug:: Engine cannot start ");
                    } else {
                        //System.out.println("Debug:: Engine can start! ");
                        count++;
                    }
                }

            } catch (JsonSyntaxException e) {
                //System.out.println("Debug:: Skip this Block -- Invalid JSON Syntax");
            }
        }
        return count;
    }

    // Get the overyear and calculate it * 12
    public int getOveryear(String input_vin) {
        int overyear;
        int monthInstallment = 0;
        try {
            //connect the blockchain_database
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blockchain_database?useTimezone=true&serverTimezone=UTC", "root", "");
            Statement stmt = con.createStatement();
            ResultSet rs = stmt.executeQuery("SELECT * FROM contracts WHERE vin = " + input_vin);

            while (rs.next()) {
                overyear = rs.getInt("overyear");
                monthInstallment = overyear * 12;
            }

        } catch (SQLException e) {
            System.out.println(e.getMessage());
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        }
        return monthInstallment;
    }

    //get the installment amount
    public HashMap<String, Integer> getInstallmentAmount(String input_vin) {
        HashMap<String, Integer> installmentAmountMap = new HashMap<>();
        try {
            //connect the blockchain_database
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/blockchain_database?useTimezone=true&serverTimezone=UTC", "root", "");
            Statement stmt = con.createStatement();
            ResultSet rs = stmt.executeQuery("SELECT * FROM contracts WHERE vin = " + input_vin);

            while (rs.next()) {
                String vin = rs.getString("vin");
                int installment = rs.getInt("installment");

                installmentAmountMap.put(vin, installment);
            }
        } catch (SQLException e) {
            System.out.println(e.getMessage());
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        }
        return installmentAmountMap;
    }

    public int getInstallment() {
        return this.installment;
    }

    public void setInstallment(int installment) {
        this.installment = installment;
    }

    //create the random true and false installment
    //true is paid, false is no paid
    public int randInstallmentTF() {
        Random installmentRand = new Random();
        int installment = (installmentRand.nextBoolean()) ? 1 : 0;
        return installment;
    }

}


