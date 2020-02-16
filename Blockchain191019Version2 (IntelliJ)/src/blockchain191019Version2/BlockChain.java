package blockchain191019Version2;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Random;

import com.google.gson.GsonBuilder;

public class BlockChain {

    public ArrayList<Block> blockchain = new ArrayList<Block>();
    public int difficulty = 4;

    // BlockChain Constructor.
    public BlockChain() {
        blockchain.add(new Block("This is first block", "0"));
        //System.out.println("Mining first block ...");
        blockchain.get(0).mineBlock(difficulty);
    }

    public void addBlock(String data) {
        blockchain.add(new Block(data, blockchain.get(blockchain.size() - 1).hash));
        //System.out.println("Mining new block ... ");
        blockchain.get(blockchain.size() - 1).mineBlock(difficulty);
    }

    public Block getLastBlock() {
        return blockchain.get(blockchain.size() - 1);
    }

    public Boolean isChainValid() {
        Block currentBlock;
        Block previousBlock;
        String hashTarget = new String(new char[difficulty]).replace('\0', '0');

        //loop through blockchain to check hashes:
        for (int i = 1; i < blockchain.size(); i++) {
            currentBlock = blockchain.get(i);
            previousBlock = blockchain.get(i - 1);

            //compare registered hash and calculated hash:
            if (!currentBlock.hash.equals(currentBlock.calculateHash())) {
                System.out.println("Current Hashes not equal");
                return false;
            }

            //compare previous hash and registered previous hash
            if (!previousBlock.hash.equals(currentBlock.previousHash)) {
                System.out.println("Previous Hashes not equal");
                return false;
            }

            //check if hash is solved
            if (!currentBlock.hash.substring(0, difficulty).equals(hashTarget)) {
                System.out.println("This block hasn't been mined");
                return false;
            }
        }
        return true;
    }

    public void checkChainValid() {
        System.out.println("BlockChain is Valid: " + isChainValid());
    }

    public void viewBlockChain() {
        String blockChainJson = new GsonBuilder().setPrettyPrinting().create().toJson(blockchain);
        System.out.println("\nThe BlockChain: ");
        System.out.println(blockChainJson);
        System.out.println("BlockChain Size: " + getSize());
    }

    // return the number of Block in this BlockChain
    public int getSize() {
        return blockchain.size();
    }

    public ArrayList<Block> getBlockChain() { return this.blockchain; }

}