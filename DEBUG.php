<?php
/*
$model  = Posts::model()->findAll();
DEBUG::output($model);
*/

/**
 * Yii DEBUG CLASS
 *
 * @author Onkar Janwa
 */
Class DEBUG {
   
    public static function output($model, $showRelations = true) 
	{
		echo "<div style='float:left;width:100%;'>";
					if(is_object($model)) 
					{
					   
							self::dumpModelDetail($model);
							
							self::dumpModelOutputRecords($model);
							
							if($showRelations)
							self::dumpModelRelations($model);
							
					}
					else {
					   if(is_array($model))
					   {
									$singleModel = $model[0];
									self::dumpModelDetail($model[0]);
									echo "Total Records:: ".count($model).'<br/>';
									$i = 0;
									foreach($model as $key => $data)
									{
											if(is_object($model[$key]))
											{
													self::dumpModelOutputRecords($model[$key], ++$i);
													if($showRelations)
															self::dumpModelRelations($model[$key]);
											}
									}
					   }
					}
		echo "</div>";
	}
        
	public static function dumpModelDetail($model)
	{
		echo "<div style='float:left;width:100%;'>";
				echo "Model: ".'<b>'.get_class($model).'</b>';
				echo "<br/>";
				echo "Table: ".'<b>'.Yii::app()->db->tablePrefix.str_replace(array("{","}"),'',$model->tableName()).'</b>';
				echo "<br/>";
		echo "</div>";
	}

	public static function dumpModelOutputRecords($model, $i=1)
	{
		echo "<div style='float:left;width:100%;'>";
				echo "<br/>";
				echo "<br/>";
				echo "<b>".$i.". Record:</b>";
				echo "<br/>";
				self::printArray($model->getAttributes());
		echo "</div>";
	}

	public static function dumpModelRelations($model)
	{
		echo "<div style='float:left;width:100%;'>";
				$relations = $model->relations();
				
				$i = 1;
				
				echo "<br/>";
				echo "<b>Model Relations:</b>";
				echo "<br/>";
				echo "<div style='float:left;margin-left:50px;width:100%;'>";
						foreach($relations as $key => $relation):
								echo "<br/>";
								echo $i++.". ".$key;
								echo "<br/>";
								echo "<div style='float:left;margin-left:70px;width:100%;'>";
								if(is_array($model->{$key}))
								{ 
										if(count($model->{$key}))
										{
												echo "<b>Total relational records found: ".count($model->{$key}).'</b><br/>';
												$data = $model->{$key};
												foreach($data as $keys => $value):
														self::printArray($data[$keys]->getAttributes());
												endforeach;
										}
								}else{
										self::printArray($model->{$key});
								}
								echo "</div>";
						endforeach;
				echo "</div>";
		echo "</div>";
	}
        
	public static function printArray($array) {
		echo "<div style='float:left;width:100%;'>";
					echo "<pre>";
					print_r($array);
					echo "</pre>";
		echo "</div>";
	}
        
	public static function isObject($model)
	{
		if(is_object($model))
				die("Not an Object");
		return true;
	}
 
}