<?php 
defined('_JEXEC') or die;
	include dirname(__FILE__)."/dropdown.php";
	include dirname(__FILE__)."/model.php";

	$subj_drop_down_data = fetchSubject();

	$subj_drop_down =  new DropdownCreator();

	$subj_drop_down->setName("subject");
	
	$subj_drop_down->setID("subject-dd");
	
	$subj_drop_down->setDataArray($subj_drop_down_data);
	$subj_drop_down->setValuekey("id");
	$subj_drop_down->setTextkey("string");
	

	$class_drop_down_data = fetchClasses();

	$class_drop_down =  new DropdownCreator();

	$class_drop_down->setID("class-dd");	
	//$class_drop_down->setClass("");  
	$class_drop_down->setName("class");
	$class_drop_down->setDataArray($class_drop_down_data);
	$class_drop_down->setValuekey("id");
	$class_drop_down->setTextkey("string");


	$term_drop_down_data = fetchTerm();

	$term_drop_down =  new DropdownCreator();

	$term_drop_down->setID("term-dd");	
	//$term_drop_down->setClass("");  
	$term_drop_down->setName("term_name");
	$term_drop_down->setDataArray($term_drop_down_data);
	$term_drop_down->setValuekey("id");
	$term_drop_down->setTextkey("string");


	$SN = 1;
	$Stuff = fetch_Subject ();
?>
<h2>Choose Subject </h2>
<div style="width: 95%; max-height: 250px; overflow-y: scroll;">
	<table class="table"  border="0" id="subject-table">
	<tbody>
	<tr>
		<th>S/N</th>
		<th>Subject Name</th>
		<th>Class</th>
		<th>Term</th>
		<th>&nbsp;</th>
	</tr>

	<?php foreach( $Stuff  AS $Key=> $stuff ) { ?>
		<tr >
			<td><?php echo ($SN++); ?></td>

		<td>
			<?php 
			echo $subj_drop_down->getTextFromKey($stuff["subject"]);
			?>
		</td>
		
		<td>
			<?php
				echo $class_drop_down->getTextFromKey($stuff['class']);
			?>
		</td>
		
		<td>
			<?php
				echo $term_drop_down->getTextFromKey($stuff["term"]);
			?>
		</td>
		<td>
			<input type="button" class="btn edit-topic" id = "<?php echo $stuff["id"]; ?>" value="Edit"/> </td>

		</tr>
<?php }  ?>
</tbody>
</table>
</div>
<div style="height: 50px"></div>

<h3 style="font-family: helvetica ">Write Notes</h3>
		<div id="info" >
			<table>
				<tbody>
					<tr>
						<td class="lbl-box">SUBJECT</td>
						<td>
							<input id="subject-box" class="" name="" type="text" value="ICT" />
						</td>
					</tr>
					<tr>
					  <td class="lbl-box" >class</td>
					  <td><label for="class"></label>
				      <input type="text" name="class" value="JSS II" id="class"></td>
				  </tr>
					<tr>
					  <td class="lbl-box" >Text Book</td>
					  <td><label for="textbook"></label>
				      <input type="text" name="textbook" id="textbook" value="New Computer Studies, Otuka, Akande &amp; Iginla"></td>
				  </tr>
					<tr>
					<td class="lbl-box">Week:</td>
					<td>
<select id="week-box" ><option value="Week">Week</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option></select>
					</td>
				</tr>
					<tr>
						<td class="lbl-box">Date:</td>
						<td>
							<input id="date-box" class="" name="" type="text" />
						</td>
					</tr>
					<tr>
						<td class="lbl-box">Title:</td>
						<td>
							<input id="title-box" class="" name="" type="text" value="software" />
						</td>
					</tr>
					<tr>
						<td class="lbl-box">Sub-Title:</td>
						<td>
							<input id="subtitle-box" class="" value="operating system"  type="text" />
						</td>
					</tr>
					<tr>
						<td class="lbl-box" >Duration:</td>
						<td>
							<input id="dur-box" value="40 " type="text" />
						</td>
					</tr>
					<tr>
					<td class="lbl-box">Period:</td>
					<td>
						<input id="period-box" class="" name="" type="text" value="2" />
					</td>
				</tr>
					<tr>
						<td class="lbl-box" >Objectives:</td>
						<td>
							<textarea style="height:50px; width:200px; " id="obj-box" class="" cols="25" name="" rows="3">At the end of the lesson students should be able to define operating system, and identify different common operating systems</textarea>
						</td>
					</tr>
					<tr>
						<td class="lbl-box" >Previous Knowledge:</td>
						<td>
							<textarea style="height:50px; width:200px; "  id="prev-box" class="" cols="25" name="" rows="3">Students should be able to use a computer system </textarea>
						</td>
					</tr>


				</tbody>
			</table>			
		</div >
		<div id="tabula" >		
			<table>
				<tbody>
					<tr>
						<td>Long Items</td>
						<td>Time</td>
						<td>Short</td>
					</tr>
					<tr>
						<td>
							<textarea id="tabula-box" style="width: 200px; height: 250px" name="" rows="25"></textarea>
					</td>
						<td>
							<textarea id="time-box" class="" cols="5" name="" rows="15" onkeyup="computeTotalTime()" style="height: 150px" ></textarea>
							<br />
							<input style="height: 30px; width: 50px" type="text" id="total-time" />
						</td>
						<td>
							<textarea style="width: 200px; height: 250px" id="present-box" class="" cols="25" name="" rows="25">Teacher ask student if they think a program is running when system is freshly booted
If student say yes teacher ask them to mention which. If no the teacher ask if they think windows is a program or not
Teacher explains that even operating systems are programs and can be changed by installing a new OS
Teacher and students mention the operating systems they know</textarea>
						</td>
					</tr>
				</tbody>
			</table>
		</div >
<table>
		<tr>
			<td class="lbl-box">Content:</td>
			<td>
				<textarea style="height: 100px" cols="40" rows="8" id="content-box">content 1
content 2
content 3
content 4
content 5</textarea>
						</td>
					</tr>
					<tr>
						<td class="lbl-box" >Material:</td>
						<td>
							<textarea style="height: 100px" id="meterial-box" class="" cols="25" name="" rows="3">computer system with windows, A bootable flash with Linux</textarea>
						</td>
					</tr>
					<tr>
					<td class="lbl-box">Evaluation:</td>
					<td>
						<input id="evaluation-box" class="" name="" type="text" value="how can you start operating system"/>
					</td>
				</tr>
					<tr>
					<td class="lbl-box">Conclusion:</td>
					<td>
						<input id="conclusion-box" class="" name="" type="text" value="Operating system is a type of system software..." />
					</td>
				</tr>
					<tr>
					<td class="lbl-box">Assignment:</td>
					<td>
						<input id="assg-box" class="" name="" type="text" value="write out the name of 6 operating systems" />
					</td>
				</tr>
	
</table>

<input type="hidden" id="start-date" />	
<input type="hidden" id="specific-subject" />	
<input type="button" id="save-button" value=" Save " />
<input type="button" value="Output" id="btn-output" onclick="getnerateNote()" />

<div id="output" ></div >

<script src ="modules/createl_esson/scripts/script.js?v=2&x=20" ></script>
<!--<script src ="/v1/paystack.js?v=2&x=20" ></script>-->