package blockchain191019Version2;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

import java.lang.reflect.Type;
import java.util.Map;
import java.util.Random;

public class OdometerReading {
	public static BlockChain blockchain = new BlockChain();
	private int odometer;

	public OdometerReading(BlockChain blockChain) {
		blockchain = blockChain;
		odometer = 0;

		// get the last block of this blockchain
		Block block = blockchain.getLastBlock();
		String blockData = block.getData();

		// restore HashMap object from json string
		Map<String, String> map;
		Type type = new TypeToken<Map<String, String>>() {}.getType();
		map = new Gson().fromJson(blockData, type);
		//System.out.println("Debug Block Data:: " + map); // debug

		// if previous block contain odometer, update the value of odometer
		if (map.containsKey("odometer")) {
			setOdometer(Integer.parseInt(map.get("odometer")));
			System.out.println("Previous Block Odometer: " + getOdometer()); // debug
		}
	}

	public int getOdometer() {
		return this.odometer;
	}

	public void setOdometer(int odometer) {
		this.odometer = odometer;
	}

	// calculate odometer by random number
	public int calculateOdometer() {
		Random odometerRand = new Random();

		int randOdometer = odometerRand.nextInt(100000);
		odometer += randOdometer;

		//System.out.println("Debug Latest Odometer:: " + getOdometer()); // debug
		return odometer;
	}

}
