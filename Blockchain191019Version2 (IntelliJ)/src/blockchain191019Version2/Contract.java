package blockchain191019Version2;

import com.google.gson.Gson;
import com.google.gson.JsonSyntaxException;
import com.google.gson.reflect.TypeToken;

import java.lang.reflect.Type;
import java.util.Map;

public class Contract {
    public static BlockChain blockchain = new BlockChain();

    public Contract(BlockChain blockChain) {
        blockchain = blockChain;
    }

    // check if the contract id exist in the BlockChain
    public boolean isContractExist(int cid) {
        boolean result = false;

        for (Block block : blockchain.getBlockChain()) {
            // get the data of the Block
            String blockData = block.getData();
            //System.out.println("Debug Block Data:: " + blockData); // debug

            // restore HashMap object from json string
            try {
                Map<String, String> map;
                Type type = new TypeToken<Map<String, String>>() {
                }.getType();
                map = new Gson().fromJson(blockData, type);

                // check contract id
                if (map.containsKey("contractid")) {
                    int currentContractId = Integer.parseInt(map.get("contractid"));
                    //System.out.println("[Contract] currentContractId :: " + currentContractId);

                    if (currentContractId == cid) {
                        result = true;
                        System.out.println("#" + cid + " Contract exist, skip!"); // debug
                    }
                }
            } catch (JsonSyntaxException | IllegalStateException e) {
                // ignore this error as it probably caused by the first block
                //e.printStackTrace();
            } catch (Exception e) {
                e.printStackTrace();
            }
        }

        return result;
    }
}
