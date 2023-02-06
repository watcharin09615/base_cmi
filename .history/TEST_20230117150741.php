<?php
//require_once("../../app_center/access.php");
ini_set('max_execution_time',300); //300 seconds = 5 minutes
ini_set('memory_limit', '-1');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
##$conn_string = "host=172.17.19.99  port=3306 dbname=edocument_wph user=root password=prg370";

$conn_string = "host=172.17.19.6  port=5432 dbname=imed user=postgres password=postgreswpt";
##ysql_connect($host, $username, $password);
##mysql_select_db($dbname);
// Create connection
$dbconn = pg_connect($conn_string) or die("Connection Error");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


#$conn = new mysqli($host, $username, $password, $dbname);
#mysqli_connect($conn,"SET NAMES utf8");
// Check connection




if($_GET["excel"] == "yes"){
	$strExcelFileName="รายงาน CycleTime" . $_POST[begdate] ."-". $_POST[enddate].".xls";
	header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
	header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
	header("Pragma:no-cache");
}
?> 

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>OPD CycleTime No Treatment  &  OPD CycleTime Treatment </title>
	<?php if($_GET["excel"] != "yes"){ ?>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<!-- Bootstrap Core CSS -->
	<link href="../Report_Outlab/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- MetisMenu CSS -->
	<link href="../Report_Outlab/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
	<!-- DataTables CSS -->
	<link href="../Report_Outlab/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
	<!-- DataTables Responsive CSS -->
	<link href="../Report_Outlab/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="../Report_Outlab/dist/css/sb-admin-2.css" rel="stylesheet">
	<!-- Custom Fonts -->
	<link href="../Report_Outlab/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<?php } ?>
		<style>
			h1	{
			margin-top: 0px; margin-bottom: 10px;
			}
		</style>
		
<style>
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 10px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.button2 {background-color: #008CBA;} /* Blue */
.button3 {background-color: #f44336;} /* Red */ 
.button4 {background-color: #e7e7e7; color: black;} /* Gray */ 
.button5 {background-color: #555555;} /* Black */
.button6 {background-color: #4CAF50;} /*green*/
table#dataTables-example {
    font-size: 12px;
}
</style>		
		
</head>
<body>
	<?php
if($_GET["excel"] != "yes") { ?>
<h1 style="background-color: #008CBA; padding:20px; color: black;  font-family:TH Sarabun New; font-size=20px; text-align: left;" >รายงาน  OPD CycleTime No Treatment  &  OPD CycleTime Treatment </h1>
<?php } ?>
<?php if($_GET["excel"] != "yes"){ ?>
<form action="#" method="POST" align="center">
	<div class="col-md-12 text_header">	
	
		<label for="txtto">เลือกเเผนก :</label>
		
		<select name="service" style="padding: 8px;" >
			<option value="0">ทั้งหมด</option>	
			<?php
				$conn_string = "host=172.17.19.6 port=5432 dbname=imed user=postgres password=postgreswpt";
				$dbconn = pg_connect($conn_string) or die("Connection Error");
				$q_service = "select base_department_id,description
								from base_department
								where description not like '%Hospitel%'
								and is_treat_patient='1'
								order by description";
				$rs_service = pg_exec($dbconn,$q_service) or die("Error to Query");
				while($rst_service = pg_fetch_array($rs_service))
				{
			?>
			

				<option value="<? echo $rst_service['base_department_id'];?>">
							<?echo $rst_service['description'];?>
				</option>
			<?}?> 
			</select>
			<label for="txtto">ตั้งแต่วันที่ : </label>
		
		<input class="btn btn-default" type="date" id="myDate" name="begdate" value="<?php echo $_POST[begdate]; ?>" required >
		
		<label for="txtto"> ถึงวันที่ : </label>
		
		<input class="btn btn-default" type="date" id="myDate" name="enddate" value="<?php echo $_POST[enddate]; ?>" required >
	
		<label for="txtto">ประเภทรายงาน : </label>

		<select name="ddl" style="padding: 8px;">
			<option value="no" <?php if($_POST["ddl"] == 'no'){ echo "selected"; } ?> >OPD No-Treatment</option>
			<option value="yes" <?php if($_POST["ddl"] == 'yes'){ echo "selected"; } ?> >OPD Treatment</option>
		</select>

		<button class="button button2" type="submit" id="btn_submit">แสดงรายละเอียด</button>
</form>	

<form method="POST" align="right" action="?excel=yes"> 
	<input  type="hidden" id="myDate" name="begdate" value="<?php echo $_POST[begdate]; ?>">
	<input type="hidden" id="myDate" name="enddate" value="<?php echo $_POST[enddate]; ?>"> 
    <input type="hidden" name="ddl" value="<?php echo $_POST["ddl"]; ?>">
	<input type="hidden" name="service" value="<?php echo $_POST["service"]; ?>">		
	<input class="button button6" style='backgroud-colour=#8bb7e8' type="submit" name="excel" value="Export Excel">
</form>


<?php } ?>

<?php
			
        if($_POST["ddl"] == ''){ exit(); }
		if($_POST["ddl"] == 'no'){
			$sql = "
			select left(visit_date_time,7) as year_month,*,'No Treatment' as type,
			case when assign_time<>'-' then 1 else 0 end as lab,
			case when xray_assign_time<>'-' then 1 else 0 end as xray,
			case when 
			imed_get_order_item_visit(visit_id) ilike '%V.%' or
			imed_get_order_item_visit(visit_id) ilike '%inj%' or
			imed_get_order_item_visit(visit_id) ilike '%amp%' or
			imed_get_order_item_visit(visit_id) ilike '%inj%' or
			imed_get_order_item_visit(visit_id) ilike '%vial%' or
			imed_get_order_item_visit(visit_id) ilike '%เข็ม%' or
			imed_get_order_item_visit(visit_id) ilike '%วัคซีน%' then 1 else 0 end as ยาฉีด,
			case when imed_get_order_item_visit(visit_id) ilike '%PV/Pap smear%' or imed_get_order_item_visit(visit_id) ilike 'PV set' then 1 else 0 end as pvpap,
			case when imed_get_order_item_visit(visit_id) ilike '%สูติกรรม%' then 1 else 0 end as สูติกรรม,
			case when imed_get_order_item_visit(visit_id) ilike '%thin%' then 1 else 0 end as thinprep,
			case when imed_get_order_item_visit(visit_id) ilike '%Pap smear%' then 1 else 0 end as papsmear,
			case when imed_get_order_item_visit(visit_id) ilike '%Echo%' or imed_get_order_item_visit(visit_id) ilike '%( U/S Echo )%'
			or imed_get_order_item_visit(visit_id) ilike '%( EST )%' or imed_get_order_item_visit(visit_id) ilike '%(EST)%' then 1 else 0 end as echoest,
			case when imed_get_order_item_visit(visit_id) ilike '%ตรวจการสะท้อนกลับของเซลล์ขนในหูชั้นใน%' then 1 else 0 end as dek,
			case when 
			imed_get_order_item_visit(visit_id) ilike '%Nasal Suction (ดูดน้ำมูก ล้างจมูก)%' or
			imed_get_order_item_visit(visit_id) ilike '%Suction  Container 1,000 cc%' or
			imed_get_order_item_visit(visit_id) ilike '%Percussion  and Nasal suction%' or
			imed_get_order_item_visit(visit_id) ilike '%Suction  Container 1,000 cc%' or
			imed_get_order_item_visit(visit_id) ilike '%Percussion,  Nasal suction and  Suction%' or
			imed_get_order_item_visit(visit_id) ilike '%ชุดทำความสะอาดหู (Suction)%' or
			imed_get_order_item_visit(visit_id) ilike '%Suction  (ดูดเสมหะ)%'
			then 1 else 0 end as hu,
			case when 
			imed_get_order_item_visit(visit_id) ilike '%Mydriacyl (F) 1% eye drop (1-2 หยด/ครั้ง)%' or
			imed_get_order_item_visit(visit_id) ilike '%ชุดอุปกรณ์สำหรับ ชุดล้างตา%' or
			imed_get_order_item_visit(visit_id) ilike '%ชุดอุปกรณ์สำหรับ I/C (ตา)%' or
			imed_get_order_item_visit(visit_id) ilike '%ชุดอุปกรณ์สำหรับ Remove Eye%'
			then 1 else 0 end as eye,
			case when 
			imed_get_order_item_visit(visit_id) ilike '%เฝือกสี%' or
			imed_get_order_item_visit(visit_id) ilike '%ชุดตกแต่งและเย็บแผล%' or
			imed_get_order_item_visit(visit_id) ilike '%ชุดทำแผล%' or
			imed_get_order_item_visit(visit_id) ilike '%Foley%s cathe%' or
			imed_get_order_item_visit(visit_id) ilike '%ชุดอุปกรณ์สำหรับ%' or
			imed_get_order_item_visit(visit_id) ilike '%Dressing Set SL Disp%' or
			imed_get_order_item_visit(visit_id) ilike '%ค่าใช้เครื่อง Intermittent NG Suctionสิทธิ UCEP%'
			
			then 1 else 0 end as bone,
			case when 
			imed_get_order_item_visit(visit_id) ilike '%ชุดดูดเสมหะ (Suction)%' or
			imed_get_order_item_visit(visit_id) ilike '%สาย suction%' or
			imed_get_order_item_visit(visit_id) ilike '%Tubing suction 1/4 x 10FT CLEA%'
			then 1 else 0 end as pui,
			imed_get_order_item_visit(visit_id) as item
			from (
				select *
				,COALESCE((SELECT case when(SELECT MAX (assign_date||' '||assign_time)FROM prescription v9 where  v9.visit_id = tem1.visit_id and pn=assigned_ref)= ''
						then null
						else (select max(assign_date||' '||assign_time) from prescription where  prescription.visit_id = tem1.visit_id and pn=assigned_ref)end ),'-')
						as med_assign
				,COALESCE((SELECT case when(SELECT MAX (approve_date||' '||approve_time)FROM prescription v9 where  v9.visit_id = tem1.visit_id and pn=assigned_ref)= ''
						then null
						else (select max(approve_date||' '||approve_time) from prescription where  prescription.visit_id = tem1.visit_id and pn=assigned_ref)end ),'-')
						as med_approve
				,COALESCE((SELECT case when(SELECT MAX (complete_date||' '||complete_time)FROM prescription v9 where  v9.visit_id = tem1.visit_id and pn=assigned_ref)= ''            then null
						else (select max(complete_date||' '||complete_time) from prescription where  prescription.visit_id = tem1.visit_id and pn=assigned_ref)end ),'-')
						as med_dispense
				,case when(tem1.แพทย์คนดึง)='' then '-' else imed_get_employee_name(tem1.แพทย์คนดึง) end as แพทย์ดึง1
				,case when(tem1.แพทย์กดFinish1)='' or tem1.แพทย์ดึง='' then '-' else COALESCE((select REPLACE(((to_timestamp((tem1.แพทย์กดFinish1),'YYYY-MM-DD HH24:MI:ss')- to_timestamp((tem1.แพทย์ดึง),'YYYY-MM-DD HH24:MI:ss')))::varchar,'-','')) ,'-') end as doc
				,case when(tem1.กดส่งห้องแพทย์)='' or tem1.แพทย์ดึง='' or tem1.กดส่งห้องแพทย์ is null or tem1.แพทย์ดึง is null then '-' else COALESCE((select REPLACE(((to_timestamp((tem1.กดส่งห้องแพทย์),'YYYY-MM-DD HH24:MI:ss')- to_timestamp((tem1.แพทย์ดึง),'YYYY-MM-DD HH24:MI:ss')))::varchar,'-','')) ,'-') end as กดส่งแพทย์ถึงแพทย์ดึง
				,case when(tem1.แพทย์กดFinish1)='' or tem1.financial_discharge_date_time='' or (tem1.แพทย์กดFinish1) is null or tem1.financial_discharge_date_time is null then '-' else COALESCE((select REPLACE(((to_timestamp((tem1.แพทย์กดFinish1),'YYYY-MM-DD HH24:MI:ss')- to_timestamp((tem1.financial_discharge_date_time),'YYYY-MM-DD HH24:MI:ss')))::varchar,'-','')) ,'-') end as doctofinan
				,case when(tem1.แพทย์กดFinish1)='' or tem1.กดส่งการเงิน='' or (tem1.แพทย์กดFinish1) is null or tem1.กดส่งการเงิน is null then '-' else COALESCE((select REPLACE(((to_timestamp((tem1.แพทย์กดFinish1),'YYYY-MM-DD HH24:MI:ss')- to_timestamp((tem1.กดส่งการเงิน),'YYYY-MM-DD HH24:MI:ss')))::varchar,'-','')) ,'-') end as doctofinan2
				,case when(tem1.financial_discharge_date_time)='' or tem1.กดส่งการเงิน='' or tem1.กดส่งการเงิน is null then '-' else COALESCE((select REPLACE(((to_timestamp((tem1.financial_discharge_date_time),'YYYY-MM-DD HH24:MI:ss')- to_timestamp((tem1.กดส่งการเงิน),'YYYY-MM-DD HH24:MI:ss')))::varchar,'-','')) ,'-') end as fin
				from(
				select *
				,case when (แพทย์คนดึง <>'-') THEN
				(COALESCE((select min(service_time_stamp.stamp_date||' '||service_time_stamp.stamp_time) from service_time_stamp
					where service_time_stamp.visit_id  = tem.visit_id
					and employee_id=แพทย์คนดึง
					and service_time_stamp.fix_time_stamp_point_id ilike 'DOCTOR_F%') ,''))
				ELSE
				(COALESCE((select min(service_time_stamp.stamp_date||' '||service_time_stamp.stamp_time) from service_time_stamp
					where service_time_stamp.visit_id  = tem.visit_id
					and service_time_stamp.fix_time_stamp_point_id ilike 'DOCTOR_F%') ,'')) END as แพทย์กดFinish1
				from
				(
					SELECT visit.visit_id,format_hn(visit.hn) AS hn
					,format_vn(visit.vn) AS vn
					,case when (new_patient='1') then 'ผู้ป่วยใหม่'
					else 'ผู้ป่วยเก่า' end as new_old
					,case when imed_get_all_attending_department_name1(visit.visit_id)='เด็ก' and (select 'Well Baby' from visit_queue where visit_id=visit.visit_id and visit_queue.next_location_spid='2021' limit 1) is not null then 'เด็ก - Well Baby' else imed_get_all_attending_department_name1(visit.visit_id) end as department
					,wpt_get_main_department_id(visit.visit_id)as department_id
					,COALESCE((SELECT max(next_location_date||' '||next_location_time) FROM visit_queue vq2 WHERE next_location_spid IN ('SPUIMED') AND vq2.visit_id  = visit.visit_id ),'') AS pui_case
					,find_attending_physician(visit.visit_id) AS doctor_f
					,COALESCE((SELECT max(next_location_date||' '||next_location_time) FROM visit_queue vq2 WHERE next_location_spid IN ('404') AND vq2.visit_id  = visit.visit_id ),'') AS กดส่งการเงิน
					,imed_get_plan_name(wph_get_first_plan_id(visit.visit_id)) AS plan
					,case when (visit.from_appointment='1')then 'นัด' else'-' end as  appointment
					,case
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '0' then 'รอการมารับบริการตามนัด'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '1' then 'มาตามนัด'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '2' then 'ผิดนัด'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '3' then 'คนไข้ walk-in'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '4' then 'LATE'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '5' then 'ยกเลิกการนัด'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '6' then 'จากการการนัด'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '7' then 'รายการนัดที่ถูกย้าย'
else '' end as status

					,(SELECT visit_date||' '||visit_time FROM visit v WHERE v.visit_id = visit.visit_id) AS visit_date_time
					,COALESCE((SELECT MIN(next_location_date||' '||next_location_time) FROM visit_queue vq WHERE next_location_spid IN ('103','102','104','116','114','118','111','105') AND vq.visit_id  = visit.visit_id),'-') AS กดส่งscreen
					,COALESCE((SELECT MIN(next_location_date||' '||next_location_time) FROM visit_queue vq2 WHERE next_location_spid IN ('709') AND vq2.visit_id  = visit.visit_id ),'-') AS กดส่งOR
					,COALESCE((SELECT MIN(next_location_date||' '||next_location_time) FROM visit_queue vq2 WHERE next_location_spid IN ('203','213','211','215','204','212','911','202','205','208','207','206','209','210','952','218','2021','SPUIMED','130','133') AND vq2.visit_id  = visit.visit_id ),'') AS กดส่งห้องแพทย์
					,COALESCE((select min(service_time_stamp.stamp_date||' '||service_time_stamp.stamp_time) from service_time_stamp  where service_time_stamp.visit_id  = visit.visit_id and service_time_stamp.fix_time_stamp_point_id ilike'DOCTOR_S%'),'') as แพทย์ดึง
					,COALESCE((select employee_id from service_time_stamp
					where service_time_stamp.visit_id  = visit.visit_id
					and service_time_stamp.fix_time_stamp_point_id ilike'DOCTOR_S%' order by stamp_date||''||stamp_time limit 1),'') as แพทย์คนดึง
					,COALESCE((select max(service_time_stamp.stamp_date||' '||service_time_stamp.stamp_time) from service_time_stamp  where service_time_stamp.visit_id  = visit.visit_id and service_time_stamp.fix_time_stamp_point_id='CASH_S'),'-') as การเงินดึงจากคิว
					,COALESCE((SELECT case when(select assigned_ref_no
									from order_item
									where assigned_ref_no<>'' and fix_item_type_id='0'
									and order_item.visit_id=visit.visit_id
									order by (execute_date||' '||execute_time) desc
									limit 1)= ' '
								then null
								else (select assigned_ref_no
									from order_item
									where assigned_ref_no<>'' and fix_item_type_id='0'
									and order_item.visit_id=visit.visit_id
									order by (execute_date||' '||execute_time) desc
									limit 1)end ),'-')
								as assigned_ref
					,COALESCE((SELECT case when(SELECT MAX (execute_date||' '||execute_time)FROM order_item  where  order_item.visit_id = visit.visit_id and assigned_ref_no<>'' and fix_item_type_id='0')= ''
								then null
								else (select max(execute_date||' '||execute_time) from order_item where  order_item.visit_id = visit.visit_id and assigned_ref_no<>''
									  and fix_item_type_id='0')end ),'-')
								as med_execute
					,COALESCE((select REPLACE(((to_timestamp((SELECT MAX (assign_date||' '||assign_time)FROM prescription v9 where  v9.visit_id = visit.visit_id),'YYYY-MM-DD HH24:MI:ss') - to_timestamp((case when((SELECT MAX (approve_date||' '||approve_time)FROM prescription v9 where  v9.visit_id = visit.visit_id))=' ' then null else ((SELECT MAX (approve_date||' '||approve_time)FROM prescription v9 where  v9.visit_id = visit.visit_id)) end),'YYYY-MM-DD HH24:MI:ss'))::VARCHAR),'-','')),'-') as med_approve_med_assign
					,COALESCE((select REPLACE(((to_timestamp((SELECT MAX (assign_date||' '||assign_time)FROM prescription v9 where  v9.visit_id = visit.visit_id),'YYYY-MM-DD HH24:MI:ss') - to_timestamp((case when((SELECT MAX (complete_date||' '||complete_time)FROM prescription v9 where  v9.visit_id = visit.visit_id))=' ' then null else ((SELECT MAX (complete_date||' '||complete_time)FROM prescription v9 where  v9.visit_id = visit.visit_id)) end),'YYYY-MM-DD HH24:MI:ss'))::VARCHAR),'-','')),'-') as complete_med_assign
					,COALESCE((case when(financial_discharge_date || ' ' || financial_discharge_time)=' ' then null else (financial_discharge_date || ' ' || financial_discharge_time) end) ,'')AS financial_discharge_date_time
					,COALESCE((select REPLACE(((to_timestamp((select max(service_time_stamp.stamp_date||' '||service_time_stamp.stamp_time) from service_time_stamp  where service_time_stamp.visit_id  = visit.visit_id and service_time_stamp.fix_time_stamp_point_id='CASH_S'),'YYYY-MM-DD HH24:MI:ss') - to_timestamp((case when(financial_discharge_date || ' ' || financial_discharge_time)=' ' then null else (financial_discharge_date || ' ' || financial_discharge_time) end),'YYYY-MM-DD HH24:MI:ss'))::VARCHAR),'-','')),'-') as cash_start_finis
					,COALESCE((select REPLACE(((to_timestamp(visit_date||' '||visit_time,'YYYY-MM-DD HH24:MI:ss') - to_timestamp((SELECT MIN(next_location_date||' '||next_location_time) FROM visit_queue vq2 WHERE next_location_spid IN ('203','213','211','215','204','212','911','202','205','208','207','206','209','210','952') AND vq2.visit_id  = visit.visit_id ),'YYYY-MM-DD HH24:MI:ss'))::VARCHAR),'-','')),'-') as regis
					,COALESCE((select REPLACE(((to_timestamp((select max(service_time_stamp.stamp_date||' '||service_time_stamp.stamp_time) from service_time_stamp  where service_time_stamp.visit_id  = visit.visit_id and service_time_stamp.fix_time_stamp_point_id='CASH_S'),'YYYY-MM-DD HH24:MI:ss') - to_timestamp((SELECT case when(SELECT MAX (complete_date||' '||complete_time)FROM prescription v9 where  v9.visit_id = visit.visit_id)=' ' then null else (select max(complete_date||' '||complete_time) from prescription where  prescription.visit_id = visit.visit_id)end ),'YYYY-MM-DD HH24:MI:ss'))::VARCHAR),'-','')) ,'-')as med
					,COALESCE((select REPLACE(((to_timestamp(visit_date||' '||visit_time,'YYYY-MM-DD HH24:MI:ss') - to_timestamp((case when(financial_discharge_date || ' ' || financial_discharge_time)=' ' then null else (financial_discharge_date || ' ' || financial_discharge_time) end),'YYYY-MM-DD HH24:MI:ss'))::VARCHAR),'-','')),'-') as time_all
					,COALESCE(assign_lab.assign_time,'-') as assign_time
					,COALESCE(assign_lab.specimen_time,'-')as specimen_time
					,COALESCE(assign_lab.complete_time,'-')as complete_time
					,COALESCE(assign_xray.xray_assign_time,'-')as xray_assign_time
					,COALESCE(assign_xray.execute_time,'-')as execute_time
					,COALESCE(assign_xray.xray_complete_time,'-')as xray_complete_time
					FROM visit
					LEFT JOIN (select assign_lab.visit_id
					,MIN(assign_lab.assign_date||' '||assign_lab.assign_time) as assign_time
					,MAX(assign_lab.receive_specimen_date||' '||assign_lab.receive_specimen_time) as specimen_time
					,MAX(assign_lab.complete_date||' '||assign_lab.complete_time) as complete_time
					from assign_lab
					group by visit_id
					)assign_lab ON visit.visit_id =  assign_lab.visit_id
					LEFT JOIN (select assign_xray.visit_id
					,MIN(assign_xray.assign_date||' '||assign_xray.assign_time) as xray_assign_time
					,MAX(assign_xray.complete_execute_date||' '||assign_xray.complete_execute_time) as execute_time
					,MAX(assign_xray.complete_date||' '||assign_xray.complete_time) as xray_complete_time
					from assign_xray
					group by assign_xray.visit_id
					)assign_xray ON visit.visit_id = assign_xray.visit_id
					WHERE visit.visit_date between '$_POST[begdate]' AND '$_POST[enddate]'
					and visit_spid not in ('951','952','953','958','959')
					and visit.fix_visit_type_id = '0'
					and visit.active <> '0'
					and visit.visit_id not in (select distinct visit.visit_id
						from visit
						left join order_item on visit.visit_id=order_item.visit_id
						left join item on order_item.item_id=item.item_id
						WHERE visit.visit_date between '$_POST[begdate]' AND '$_POST[enddate]'
						and (item_name not ilike 'V.%' or item_name not ilike '%วัคซีน%'
						or item_name not ilike '%PV/Pap smear%' or item_name not ilike '%สูติกรรม%'
						or item_name not ilike '%thin %' or item_name not ilike '%Pap smear%'
						or item_name not ilike '% Echo %' or item_name not ilike '%( U/S Echo )%' or item_name not ilike '%(EST)%' or item_name not ilike '%( EST )%'
						or item_name not ilike '%PV set%'
						or order_item.fix_item_type_id<>'2' or order_item.fix_item_type_id<>'1' or item.base_drug_type_id not in ('02','10')
						or order_item.item_id not in ('0608101507530000089',
												'108082311010894901',
												'109121709164679201',
												'110102209504015601',
												'111012110212932601',
												'12226_041123101506013_0300047',
												'12226_041123101506013_0300100',
												'12226_041123101506013_0300104',
												'12226_041123101506013_0300124',
												'12226_041123101506013_0300125',
												'12226_041123101506013_0300136',
												'12226_041123101506014_0400151',
												'12226_041123101506014_0400152',
												'12226_041123101506014_0400153',
												'12226_041123101506014_0400157',
												'12226_041123101506014_0400158',
												'12226_041123101506014_0400160',
												'12226_041123101506014_0400161',
												'12226_041123101506014_0400163',
												'12226_041123101506014_0400625',
												'12226_041123101506014_0400763',
												'12226_041123101506014_0400764',
												'12226_041123101506014_0400765',
												'12226_041123101506014_0400766',
												'12226_041123101506014_0400767',
												'12226_041123101506014_0400768',
												'12226_050713102713061_26317',
												'314060208454033001',
												'315113010445440501',
												'315113010463279401',
												'315113010481635101',
												'318051415475871701',
												'319071910194195501',
												'319071910212726901',
												'319071910223999101',
												'319071910354736501',
												'319090914035708001',
												'319090914070081601',
												'319090914090932401',
												'319090914111498901',
												'319091911433745001',
												'319102909431937601',
												'418102121130583701',
												'419061713485201801',
												'419061717212102401',
												'419061807513151101',
												'419061809052467501',
												'315040315110979601')
							)
						group by visit.visit_id)
					order by department,visit_date_time
					)tem
				)tem1
			) as tmp ";

			if($service == '0'){
				$sql = $sql."
						order by visit_date_time
							";
			}else{
				$sql = $sql."
						where department_id like '%$service%'
						order by visit_date_time
							";

			} 


							
			}

			if($_POST["ddl"] == 'yes'){
				$sql = "
				select left(visit_date_time,7) as year_month,*,'Treatment' as type,
case when assign_time<>'-' then 1 else 0 end as lab,
case when xray_assign_time<>'-' then 1 else 0 end as xray,
case when 
imed_get_order_item_visit(visit_id) ilike '%V.%' or
imed_get_order_item_visit(visit_id) ilike '%inj%' or
imed_get_order_item_visit(visit_id) ilike '%amp%' or
imed_get_order_item_visit(visit_id) ilike '%inj%' or
imed_get_order_item_visit(visit_id) ilike '%vial%' or
imed_get_order_item_visit(visit_id) ilike '%เข็ม%' or
imed_get_order_item_visit(visit_id) ilike '%วันซีน%'
then 1 else 0 end as ยาฉีด,
case when imed_get_order_item_visit(visit_id) ilike '%PV/Pap smear%' or imed_get_order_item_visit(visit_id) ilike 'PV set' then 1 else 0 end as pvpap,
case when imed_get_order_item_visit(visit_id) ilike '%สูติกรรม%' then 1 else 0 end as สูติกรรม,
case when imed_get_order_item_visit(visit_id) ilike '%thin%' then 1 else 0 end as thinprep,
case when imed_get_order_item_visit(visit_id) ilike '%Pap smear%' then 1 else 0 end as papsmear,
case when imed_get_order_item_visit(visit_id) ilike '%Echo%' or imed_get_order_item_visit(visit_id) ilike '%( U/S Echo )%'
or imed_get_order_item_visit(visit_id) ilike '%( EST )%' or imed_get_order_item_visit(visit_id) ilike '%(EST)%' then 1 else 0 end as echoest,
case when imed_get_order_item_visit(visit_id) ilike '%ตรวจการสะท้อนกลับของเซลล์ขนในหูชั้นใน%' then 1 else 0 end as dek,
case when 
imed_get_order_item_visit(visit_id) ilike '%Nasal Suction (ดูดน้ำมูก ล้างจมูก)%' or
imed_get_order_item_visit(visit_id) ilike '%Suction  Container 1,000 cc%' or
imed_get_order_item_visit(visit_id) ilike '%Percussion  and Nasal suction%' or
imed_get_order_item_visit(visit_id) ilike '%Suction  Container 1,000 cc%' or
imed_get_order_item_visit(visit_id) ilike '%Percussion,  Nasal suction and  Suction%' or
imed_get_order_item_visit(visit_id) ilike '%ชุดทำความสะอาดหู (Suction)%' or
imed_get_order_item_visit(visit_id) ilike '%Suction  (ดูดเสมหะ)%'
then 1 else 0 end as hu,
case when 
imed_get_order_item_visit(visit_id) ilike '%Mydriacyl (F) 1% eye drop (1-2 หยด/ครั้ง)%' or
imed_get_order_item_visit(visit_id) ilike '%ชุดอุปกรณ์สำหรับ ชุดล้างตา%' or
imed_get_order_item_visit(visit_id) ilike '%ชุดอุปกรณ์สำหรับ I/C (ตา)%' or
imed_get_order_item_visit(visit_id) ilike '%ชุดอุปกรณ์สำหรับ Remove Eye%'
then 1 else 0 end as eye,
case when 
imed_get_order_item_visit(visit_id) ilike '%เฝือกสี%' or
imed_get_order_item_visit(visit_id) ilike '%ชุดตกแต่งและเย็บแผล%' or
imed_get_order_item_visit(visit_id) ilike '%ชุดทำแผล%' or
imed_get_order_item_visit(visit_id) ilike '%Foley%s cathe%' or
imed_get_order_item_visit(visit_id) ilike '%ชุดอุปกรณ์สำหรับ%' or
imed_get_order_item_visit(visit_id) ilike '%Dressing Set SL Disp%' or
imed_get_order_item_visit(visit_id) ilike '%ค่าใช้เครื่อง Intermittent NG Suctionสิทธิ UCEP%'

then 1 else 0 end as bone,
case when 
imed_get_order_item_visit(visit_id) ilike '%ชุดดูดเสมหะ (Suction)%' or
imed_get_order_item_visit(visit_id) ilike '%สาย suction%' or
imed_get_order_item_visit(visit_id) ilike '%Tubing suction 1/4 x 10FT CLEA%'
then 1 else 0 end as pui,
imed_get_order_item_visit(visit_id) as item
from (
    select *
    ,COALESCE((SELECT case when(SELECT MAX (assign_date||' '||assign_time)FROM prescription v9 where  v9.visit_id = tem1.visit_id and pn=assigned_ref)= ''
            then null
            else (select max(assign_date||' '||assign_time) from prescription where  prescription.visit_id = tem1.visit_id and pn=assigned_ref)end ),'-')
            as med_assign
    ,COALESCE((SELECT case when(SELECT MAX (approve_date||' '||approve_time)FROM prescription v9 where  v9.visit_id = tem1.visit_id and pn=assigned_ref)= ''
            then null
            else (select max(approve_date||' '||approve_time) from prescription where  prescription.visit_id = tem1.visit_id and pn=assigned_ref)end ),'-')
            as med_approve
    ,COALESCE((SELECT case when(SELECT MAX (complete_date||' '||complete_time)FROM prescription v9 where  v9.visit_id = tem1.visit_id and pn=assigned_ref)= ''            then null
            else (select max(complete_date||' '||complete_time) from prescription where  prescription.visit_id = tem1.visit_id and pn=assigned_ref)end ),'-')
            as med_dispense
    ,case when(tem1.แพทย์คนดึง)='' then '-' else imed_get_employee_name(tem1.แพทย์คนดึง) end as แพทย์ดึง1
    ,case when(tem1.แพทย์กดFinish1)='' or tem1.แพทย์ดึง='' then '-' else COALESCE((select REPLACE(((to_timestamp((tem1.แพทย์กดFinish1),'YYYY-MM-DD HH24:MI:ss')- to_timestamp((tem1.แพทย์ดึง),'YYYY-MM-DD HH24:MI:ss')))::varchar,'-','')) ,'-') end as doc
    ,case when(tem1.กดส่งห้องแพทย์)='' or tem1.แพทย์ดึง='' or tem1.กดส่งห้องแพทย์ is null or tem1.แพทย์ดึง is null then '-' else COALESCE((select REPLACE(((to_timestamp((tem1.กดส่งห้องแพทย์),'YYYY-MM-DD HH24:MI:ss')- to_timestamp((tem1.แพทย์ดึง),'YYYY-MM-DD HH24:MI:ss')))::varchar,'-','')) ,'-') end as กดส่งแพทย์ถึงแพทย์ดึง
    ,case when(tem1.แพทย์กดFinish1)='' or tem1.financial_discharge_date_time='' or (tem1.แพทย์กดFinish1) is null or tem1.financial_discharge_date_time is null then '-' else COALESCE((select REPLACE(((to_timestamp((tem1.แพทย์กดFinish1),'YYYY-MM-DD HH24:MI:ss')- to_timestamp((tem1.financial_discharge_date_time),'YYYY-MM-DD HH24:MI:ss')))::varchar,'-','')) ,'-') end as doctofinan
    ,case when(tem1.แพทย์กดFinish1)='' or tem1.กดส่งการเงิน='' or (tem1.แพทย์กดFinish1) is null or tem1.กดส่งการเงิน is null then '-' else COALESCE((select REPLACE(((to_timestamp((tem1.แพทย์กดFinish1),'YYYY-MM-DD HH24:MI:ss')- to_timestamp((tem1.กดส่งการเงิน),'YYYY-MM-DD HH24:MI:ss')))::varchar,'-','')) ,'-') end as doctofinan2
    ,case when(tem1.financial_discharge_date_time)='' or tem1.กดส่งการเงิน='' or tem1.กดส่งการเงิน is null then '-' else COALESCE((select REPLACE(((to_timestamp((tem1.financial_discharge_date_time),'YYYY-MM-DD HH24:MI:ss')- to_timestamp((tem1.กดส่งการเงิน),'YYYY-MM-DD HH24:MI:ss')))::varchar,'-','')) ,'-') end as fin
    from(
    select *
    ,case when (แพทย์คนดึง <>'-') THEN
    (COALESCE((select min(service_time_stamp.stamp_date||' '||service_time_stamp.stamp_time) from service_time_stamp
        where service_time_stamp.visit_id  = tem.visit_id
        and employee_id=แพทย์คนดึง
        and service_time_stamp.fix_time_stamp_point_id ilike 'DOCTOR_F%') ,''))
    ELSE
    (COALESCE((select min(service_time_stamp.stamp_date||' '||service_time_stamp.stamp_time) from service_time_stamp
        where service_time_stamp.visit_id  = tem.visit_id
        and service_time_stamp.fix_time_stamp_point_id ilike 'DOCTOR_F%') ,'')) END as แพทย์กดFinish1
    from
    (
        SELECT visit.visit_id,format_hn(visit.hn) AS hn
        ,format_vn(visit.vn) AS vn
        ,case when (new_patient='1') then 'ผู้ป่วยใหม่'
        else 'ผู้ป่วยเก่า' end as new_old
        ,case when imed_get_all_attending_department_name1(visit.visit_id)='เด็ก' and (select 'Well Baby' from visit_queue where visit_id=visit.visit_id and visit_queue.next_location_spid='2021' limit 1) is not null then 'เด็ก - Well Baby' else imed_get_all_attending_department_name1(visit.visit_id) end as department
		,wpt_get_main_department_id(visit.visit_id) as department_id
		,COALESCE((SELECT max(next_location_date||' '||next_location_time) FROM visit_queue vq2 WHERE next_location_spid IN ('SPUIMED') AND vq2.visit_id  = visit.visit_id ),'') AS pui_case
        ,find_attending_physician(visit.visit_id) AS doctor_f
        ,COALESCE((SELECT max(next_location_date||' '||next_location_time) FROM visit_queue vq2 WHERE next_location_spid IN ('404') AND vq2.visit_id  = visit.visit_id ),'') AS กดส่งการเงิน
        ,imed_get_plan_name(wph_get_first_plan_id(visit.visit_id)) AS plan
        ,case when (visit.from_appointment='1')then 'นัด' else'-' end as  appointment
		,case
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '0' then 'รอการมารับบริการตามนัด'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '1' then 'มาตามนัด'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '2' then 'ผิดนัด'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '3' then 'คนไข้ walk-in'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '4' then 'LATE'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '5' then 'ยกเลิกการนัด'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '6' then 'จากการการนัด'
when (select max(fix_appointment_status_id) from appointment where visit.visit_id = appointment.visit_id) = '7' then 'รายการนัดที่ถูกย้าย'
else '' end as status

        ,(SELECT visit_date||' '||visit_time FROM visit v WHERE v.visit_id = visit.visit_id) AS visit_date_time
        ,COALESCE((SELECT MIN(next_location_date||' '||next_location_time) FROM visit_queue vq WHERE next_location_spid IN ('103','102','104','116','114','118','111','105') AND vq.visit_id  = visit.visit_id),'-') AS กดส่งscreen
        ,COALESCE((SELECT MIN(next_location_date||' '||next_location_time) FROM visit_queue vq2 WHERE next_location_spid IN ('709') AND vq2.visit_id  = visit.visit_id ),'-') AS กดส่งOR
		,COALESCE((SELECT MIN(next_location_date||' '||next_location_time) FROM visit_queue vq2 WHERE next_location_spid IN ('203','213','211','215','204','212','911','202','205','208','207','206','209','210','952','218','2021','SPUIMED','130','133') AND vq2.visit_id  = visit.visit_id ),'') AS กดส่งห้องแพทย์
        ,COALESCE((select min(service_time_stamp.stamp_date||' '||service_time_stamp.stamp_time) from service_time_stamp  where service_time_stamp.visit_id  = visit.visit_id and service_time_stamp.fix_time_stamp_point_id ilike'DOCTOR_S%'),'') as แพทย์ดึง
        ,COALESCE((select employee_id from service_time_stamp
        where service_time_stamp.visit_id  = visit.visit_id
        and service_time_stamp.fix_time_stamp_point_id ilike'DOCTOR_S%' order by stamp_date||''||stamp_time limit 1),'') as แพทย์คนดึง
        ,COALESCE((select max(service_time_stamp.stamp_date||' '||service_time_stamp.stamp_time) from service_time_stamp  where service_time_stamp.visit_id  = visit.visit_id and service_time_stamp.fix_time_stamp_point_id='CASH_S'),'-') as การเงินดึงจากคิว
        ,COALESCE((SELECT case when(select assigned_ref_no
                        from order_item
                        where assigned_ref_no<>'' and fix_item_type_id='0'
                        and order_item.visit_id=visit.visit_id
                        order by (execute_date||' '||execute_time) desc
                        limit 1)= ' '
                    then null
                    else (select assigned_ref_no
                        from order_item
                        where assigned_ref_no<>'' and fix_item_type_id='0'
                        and order_item.visit_id=visit.visit_id
                        order by (execute_date||' '||execute_time) desc
                        limit 1)end ),'-')
                    as assigned_ref
        ,COALESCE((SELECT case when(SELECT MAX (execute_date||' '||execute_time)FROM order_item  where  order_item.visit_id = visit.visit_id and assigned_ref_no<>'' and fix_item_type_id='0')= ''
                    then null
                    else (select max(execute_date||' '||execute_time) from order_item where  order_item.visit_id = visit.visit_id and assigned_ref_no<>''
                          and fix_item_type_id='0')end ),'-')
                    as med_execute
        ,COALESCE((select REPLACE(((to_timestamp((SELECT MAX (assign_date||' '||assign_time)FROM prescription v9 where  v9.visit_id = visit.visit_id),'YYYY-MM-DD HH24:MI:ss') - to_timestamp((case when((SELECT MAX (approve_date||' '||approve_time)FROM prescription v9 where  v9.visit_id = visit.visit_id))=' ' then null else ((SELECT MAX (approve_date||' '||approve_time)FROM prescription v9 where  v9.visit_id = visit.visit_id)) end),'YYYY-MM-DD HH24:MI:ss'))::VARCHAR),'-','')),'-') as med_approve_med_assign
        ,COALESCE((select REPLACE(((to_timestamp((SELECT MAX (assign_date||' '||assign_time)FROM prescription v9 where  v9.visit_id = visit.visit_id),'YYYY-MM-DD HH24:MI:ss') - to_timestamp((case when((SELECT MAX (complete_date||' '||complete_time)FROM prescription v9 where  v9.visit_id = visit.visit_id))=' ' then null else ((SELECT MAX (complete_date||' '||complete_time)FROM prescription v9 where  v9.visit_id = visit.visit_id)) end),'YYYY-MM-DD HH24:MI:ss'))::VARCHAR),'-','')),'-') as complete_med_assign
        ,COALESCE((case when(financial_discharge_date || ' ' || financial_discharge_time)=' ' then null else (financial_discharge_date || ' ' || financial_discharge_time) end) ,'')AS financial_discharge_date_time
        ,COALESCE((select REPLACE(((to_timestamp((select max(service_time_stamp.stamp_date||' '||service_time_stamp.stamp_time) from service_time_stamp  where service_time_stamp.visit_id  = visit.visit_id and service_time_stamp.fix_time_stamp_point_id='CASH_S'),'YYYY-MM-DD HH24:MI:ss') - to_timestamp((case when(financial_discharge_date || ' ' || financial_discharge_time)=' ' then null else (financial_discharge_date || ' ' || financial_discharge_time) end),'YYYY-MM-DD HH24:MI:ss'))::VARCHAR),'-','')),'-') as cash_start_finis
        ,COALESCE((select REPLACE(((to_timestamp(visit_date||' '||visit_time,'YYYY-MM-DD HH24:MI:ss') - to_timestamp((SELECT MIN(next_location_date||' '||next_location_time) FROM visit_queue vq2 WHERE next_location_spid IN ('203','213','211','215','204','212','911','202','205','208','207','206','209','210','952') AND vq2.visit_id  = visit.visit_id ),'YYYY-MM-DD HH24:MI:ss'))::VARCHAR),'-','')),'-') as regis
        ,COALESCE((select REPLACE(((to_timestamp((select max(service_time_stamp.stamp_date||' '||service_time_stamp.stamp_time) from service_time_stamp  where service_time_stamp.visit_id  = visit.visit_id and service_time_stamp.fix_time_stamp_point_id='CASH_S'),'YYYY-MM-DD HH24:MI:ss') - to_timestamp((SELECT case when(SELECT MAX (complete_date||' '||complete_time)FROM prescription v9 where  v9.visit_id = visit.visit_id)=' ' then null else (select max(complete_date||' '||complete_time) from prescription where  prescription.visit_id = visit.visit_id)end ),'YYYY-MM-DD HH24:MI:ss'))::VARCHAR),'-','')) ,'-')as med
        ,COALESCE((select REPLACE(((to_timestamp(visit_date||' '||visit_time,'YYYY-MM-DD HH24:MI:ss') - to_timestamp((case when(financial_discharge_date || ' ' || financial_discharge_time)=' ' then null else (financial_discharge_date || ' ' || financial_discharge_time) end),'YYYY-MM-DD HH24:MI:ss'))::VARCHAR),'-','')),'-') as time_all
        ,COALESCE(assign_lab.assign_time,'-') as assign_time
        ,COALESCE(assign_lab.specimen_time,'-')as specimen_time
        ,COALESCE(assign_lab.complete_time,'-')as complete_time
        ,COALESCE(assign_xray.xray_assign_time,'-')as xray_assign_time
        ,COALESCE(assign_xray.execute_time,'-')as execute_time
        ,COALESCE(assign_xray.xray_complete_time,'-')as xray_complete_time
        FROM visit
        LEFT JOIN (select assign_lab.visit_id
        ,MIN(assign_lab.assign_date||' '||assign_lab.assign_time) as assign_time
        ,MAX(assign_lab.receive_specimen_date||' '||assign_lab.receive_specimen_time) as specimen_time
        ,MAX(assign_lab.complete_date||' '||assign_lab.complete_time) as complete_time
        from assign_lab
        group by visit_id
        )assign_lab ON visit.visit_id =  assign_lab.visit_id

        LEFT JOIN (select assign_xray.visit_id
        ,MIN(assign_xray.assign_date||' '||assign_xray.assign_time) as xray_assign_time
        ,MAX(assign_xray.complete_execute_date||' '||assign_xray.complete_execute_time) as execute_time
        ,MAX(assign_xray.complete_date||' '||assign_xray.complete_time) as xray_complete_time
        from assign_xray
        group by assign_xray.visit_id
        )assign_xray ON visit.visit_id = assign_xray.visit_id
        WHERE visit.visit_date between '$_POST[begdate]' AND '$_POST[enddate]'
        and visit_spid not in ('951','952','953','958','959')
        and visit.fix_visit_type_id = '0'
        and visit.active <> '0'
        and visit.visit_id in (select distinct visit.visit_id
            from visit
            left join order_item on visit.visit_id=order_item.visit_id
            left join item on order_item.item_id=item.item_id
            WHERE visit.visit_date between '$_POST[begdate]' AND '$_POST[enddate]'
            and (item_name not ilike 'V.%' or item_name not ilike '%วัคซีน%'
            or item_name not ilike '%PV/Pap smear%' or item_name not ilike '%สูติกรรม%'
            or item_name not ilike '%thin %' or item_name not ilike '%Pap smear%'
            or item_name not ilike '% Echo %' or item_name not ilike '%( U/S Echo )%' or item_name not ilike '%(EST)%' or item_name not ilike '%( EST )%'
            or item_name not ilike '%PV set%'
            or order_item.fix_item_type_id<>'2' or order_item.fix_item_type_id<>'1' or item.base_drug_type_id not in ('02','10')
            or order_item.item_id not in ('0608101507530000089',
                                    '108082311010894901',
                                    '109121709164679201',
                                    '110102209504015601',
                                    '111012110212932601',
                                    '12226_041123101506013_0300047',
                                    '12226_041123101506013_0300100',
                                    '12226_041123101506013_0300104',
                                    '12226_041123101506013_0300124',
                                    '12226_041123101506013_0300125',
                                    '12226_041123101506013_0300136',
                                    '12226_041123101506014_0400151',
                                    '12226_041123101506014_0400152',
                                    '12226_041123101506014_0400153',
                                    '12226_041123101506014_0400157',
                                    '12226_041123101506014_0400158',
                                    '12226_041123101506014_0400160',
                                    '12226_041123101506014_0400161',
                                    '12226_041123101506014_0400163',
                                    '12226_041123101506014_0400625',
                                    '12226_041123101506014_0400763',
                                    '12226_041123101506014_0400764',
                                    '12226_041123101506014_0400765',
                                    '12226_041123101506014_0400766',
                                    '12226_041123101506014_0400767',
                                    '12226_041123101506014_0400768',
                                    '12226_050713102713061_26317',
                                    '314060208454033001',
                                    '315113010445440501',
                                    '315113010463279401',
                                    '315113010481635101',
                                    '318051415475871701',
                                    '319071910194195501',
                                    '319071910212726901',
                                    '319071910223999101',
                                    '319071910354736501',
                                    '319090914035708001',
                                    '319090914070081601',
                                    '319090914090932401',
                                    '319090914111498901',
                                    '319091911433745001',
                                    '319102909431937601',
                                    '418102121130583701',
                                    '419061713485201801',
                                    '419061717212102401',
                                    '419061807513151101',
                                    '419061809052467501',
                                    '315040315110979601')
                )
            group by visit.visit_id)
        order by department ,visit_date_time
        )tem
    )tem1
) as tmp ";

			if($service == '0'){
				$sql = $sql."
						order by visit_date_time
							";
			}else{
				$sql = $sql."
						where department_id like '%$service%'
						order by visit_date_time
							";

			} 
								
				}
				
	$query = pg_query($dbconn,$sql) or die("Error to Query");


	$no=1;
?>
	
	<div class="panel-body">
		<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
				  <tr>
					<th>year_month</th>
					<th>visit_id</th>
					<th>hn</th>
					<th>vn</th>
					<th>new_old</th>
					<th>department</th>
					<th>PUI</th>
					<th>doctor_f</th>
					<th>กดส่งการเงิน</th>
                    <th>plan</th>
                    <th>appointment</th>
					<th>status</th>
                    <th>visit_date_time</th>
                    <th>กดส่งscreen</th>
					<th>กดส่งor</th>
					<th>กดส่งห้องแพทย์</th>
					<th>แพทย์ดึง</th>
					<th>แพทย์คนดึง</th>
					<th>การเงินดึงจากคิว</th>
					<th>assigned_ref</th>
					<th>med_execute</th>
					<th>med_approve-med_assign</th>
                    <th>complete-med_assign</th>
                    <th>financial_discharge_date_time</th>
                    <th>cash_start_finis</th>
                    <th>regis</th>
					<th>med</th>
                    <th>time_all</th>
                    <th>assign_time</th>
					<th>specimen_time</th>
					<th>complete_time</th>
					<th>xray_assign_time</th>
					<th>execute_time</th>
					<th>xray_complete_time</th>
					<th>แพทย์กดfinish1</th>
					<th>med_assign</th>
					<th>med_approve</th>
                    <th>med_dispense</th>
                    <th>แพทย์ดึง1</th>
                    <th>doc</th>
                    <th>กดส่งแพทย์ถึงแพทย์ดึง</th>
					<th>แพทย์finishถึงจำหน่ายการเงิน</th>
                    <th>แพทย์finishถึงกดส่งไปการเงิน</th>
                    <th>กดส่งไปการเงินถึงจำหน่ายทางการเงิน</th>
                    <th>type</th>
                    <th>lab</th>
					<th>xray</th>
                    <th>ยาฉีด</th>
                    <th>PV/Pap</th>
					<th>สูติกรรม</th>
					<th>ThinPrep</th>
					<th>Pap smear</th>
					<th>Echo/EST</th>
					<th>หัตถการกลุ่มผู้ป่วยกุมาร</th>
					<th>หัตถการกลุ่มผู้ป่วยหูคอจมูก</th>
					<th>หัตถการทางจักษุ</th>
					<th>หัตถการทางศัลยกรรมและกระดูก</th>
                    <th>หัตถการทางอายุรกรรม</th>
                    <th>order_item</th>
				  </tr>
                </thead>
                
				<tbody>
                   <?php	$no=1;
	 						while($row = pg_fetch_assoc($query))
							{
                                
								echo "<tr>";
								echo "<td>" . $row["year_month"]. "</td>";
								echo "<td>" . $row["visit_id"]. "</td>";
								echo "<td>" . $row["hn"]. "</td>";
								echo "<td>" . $row["vn"]. "</td>";
								echo "<td>" . $row["new_old"]. "</td>";
								echo "<td>" . $row["department"]. "</td>";
								echo "<td>" . $row["pui_case"]. "</td>";
								echo "<td>" . $row["doctor_f"]. "</td>";
								echo "<td>" . $row["กดส่งการเงิน"]. "</td>";
								echo "<td>" . $row["plan"]. "</td>";
								echo "<td>" . $row["appointment"]. "</td>";
								echo "<td>" . $row["status"]. "</td>";
								echo "<td>" . $row["visit_date_time"]. "</td>";
								echo "<td>" . $row["กดส่งscreen"]. "</td>";
								echo "<td>" . $row["กดส่งor"]. "</td>";
								echo "<td>" . $row["กดส่งห้องแพทย์"]. "</td>";
								echo "<td>" . $row["แพทย์ดึง"]. "</td>";
								echo "<td>" . $row["แพทย์คนดึง"]. "</td>";
								echo "<td>" . $row["การเงินดึงจากคิว"]. "</td>";
								echo "<td>" . $row["assigned_ref"]. "</td>";
								echo "<td>" . $row["med_execute"]. "</td>";
								echo "<td>" . $row["med_approve_med_assign"]. "</td>";
								echo "<td>" . $row["complete_med_assign"]. "</td>";
								echo "<td>" . $row["financial_discharge_date_time"]. "</td>";
								echo "<td>" . $row["cash_start_finis"]. "</td>";
								echo "<td>" . $row["regis"]. "</td>";
								echo "<td>" . $row["med"]. "</td>";
								echo "<td>" . $row["time_all"]. "</td>";
								echo "<td>" . $row["assign_time"]. "</td>";
								echo "<td>" . $row["specimen_time"]. "</td>";
								echo "<td>" . $row["complete_time"]. "</td>";
								echo "<td>" . $row["xray_assign_time"]. "</td>";
								echo "<td>" . $row["execute_time"]. "</td>";
								echo "<td>" . $row["xray_complete_time"]. "</td>";
								echo "<td>" . $row["แพทย์กดfinish1"]. "</td>";
								echo "<td>" . $row["med_assign"]. "</td>";
								echo "<td>" . $row["med_approve"]. "</td>";
								echo "<td>" . $row["med_dispense"]. "</td>";
								echo "<td>" . $row["แพทย์ดึง1"]. "</td>";
								echo "<td>" . $row["doc"]. "</td>";
								echo "<td>" . $row["กดส่งแพทย์ถึงแพทย์ดึง"]. "</td>";
								echo "<td>" . $row["doctofinan"]. "</td>";
								echo "<td>" . $row["doctofinan2"]. "</td>";
								echo "<td>" . $row["fin"]. "</td>";
								echo "<td>" . $row["type"]. "</td>";
								echo "<td>" . $row["lab"]. "</td>";
								echo "<td>" . $row["xray"]. "</td>";
								echo "<td>" . $row["ยาฉีด"]. "</td>";
								echo "<td>" . $row["pvpap"]. "</td>";
								echo "<td>" . $row["สูติกรรม"]. "</td>";
								echo "<td>" . $row["thinprep"]. "</td>";
								echo "<td>" . $row["papsmear"]. "</td>";
								echo "<td>" . $row["echoest"]. "</td>";
								echo "<td>" . $row["dek"]. "</td>";
								echo "<td>" . $row["hu"]. "</td>";
								echo "<td>" . $row["eye"]. "</td>";
								echo "<td>" . $row["bone"]. "</td>";
								echo "<td>" . $row["pui"]. "</td>";
								echo "<td>" . $row["item"]. "</td>";	
								echo "</tr>";
							}
							pg_close($dbconn);
					?>
				</tbody>

	</div>
<?php if($_GET["excel"] != "yes"){ ?>
    <!-- jQuery -->
    <script src="../Report_Outlab/vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../Report_Outlab/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../Report_Outlab/vendor/metisMenu/metisMenu.min.js"></script>
    <!-- DataTables JavaScript -->
    <script src="../Report_Outlab/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../Report_Outlab/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../Report_Outlab/vendor/datatables-responsive/dataTables.responsive.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../Report_Outlab/dist/js/sb-admin-2.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true ,
				"lengthMenu": [[100,200,300,400,500,-1], [100,200,300,400,500,"All"]]
        });
    });
</script>
<?php } ?>
</body>
</html>