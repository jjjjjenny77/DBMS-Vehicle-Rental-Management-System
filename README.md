# DBMS-Vehicle-Rental-Management-System
> This note record and share the final project of DBMS course in 【112下】 about constructing a vehicle rental system including administrator side
## Project Overview:
Create a system for managing a vehicle rental service that allows users to
book vehicles online and manage their rentals.
Construct a database and provide an ER diagram for the following tasks.
## Basic Functional Requirements:
1. User Capabilities:
∙ Account Management: Users can register, login, and manage their
accounts.
∙ Vehicle Booking: Browse available vehicles(at least two types of
vehicles), book rentals, and manage bookings(cancel order).
∙ Payment System: Process payments for rentals(at least three payment
methods) and receive invoices.
∙ Review and Ratings: Rate vehicles and provide feedback on rental
experiences.
2. System Manager Capabilities:
∙ Vehicle Management: Add, update, and remove vehicles from the
system.
∙ Booking Management: View and manage all bookings, check vehicle
availability.
∙ Customer Service: Handle customer inquiries and manage disputes.
∙ Financial Overviews: Track payments, generate revenue reports, and
manage pricing models.
3. At least six locations(manager can add and delete sites)
4. Fool-proof design
## ER diagram
![image](https://github.com/jjjjjenny77/images/blob/main/ER%20diagram.png)
## How to run the code
* Login in http://localhost/phpMyAdmin/.
* Use the SQL code below to create table.
* Download all files in my "code" folder and put them in the WWW folder
* Change the user account and password in mysql_connect.inc.php
* Use browser to type in the URL bar: localhost/homepage.html
## Watch my demo vedio below!
https://youtu.be/gm3NfEpTphY
## Codes to create table :
```SQL
CREATE TABLE CUSTOMER (
  CUS_IDNUM     VARCHAR(10) PRIMARY KEY,
  CUS_PASSWORD  VARCHAR(30),
  CUS_NAME      VARCHAR(50),
  CUS_PHONE     VARCHAR(11),
  CUS_EMAIL     VARCHAR(200)
);
INSERT INTO CUSTOMER VALUES('H225871103','vicky123','張殷祈','0979576014','vicky4022531@gmail.com');
INSERT INTO CUSTOMER VALUES('H225902416','jenny123','Jenny','0919920005','jennyxu0569.mg10@nycu.edu.tw');
INSERT INTO CUSTOMER VALUES('B223380210','981981','白欣怡','0987297107','cynthiapai.114.mg10@nycu.edu.tw');
INSERT INTO CUSTOMER VALUES('C123456789','password1','林志玲','0987654321','lin.chiling@gmail.com');
INSERT INTO CUSTOMER VALUES('D987654321','password2','王大明','0912345678','daming.wang@example.com');
CREATE TABLE ADMIN (
  ADM_IDNUM     VARCHAR(10) PRIMARY KEY,
  ADM_PASSWORD  VARCHAR(15)
);
INSERT INTO ADMIN VALUES('A000000000','981981');
INSERT INTO ADMIN VALUES('B111111111','189189');
INSERT INTO ADMIN VALUES('C222222222','password1');
CREATE TABLE PRICE (
  VEH_MODEL  VARCHAR(30) PRIMARY KEY,
  PRI_PRICE  DECIMAL(10,2)
);
INSERT INTO PRICE VALUES('TOYOTA YARIS', 1200);
INSERT INTO PRICE VALUES('FORD KUGA', 1400);
INSERT INTO PRICE VALUES('TOYOTA VIOS', 1300);
INSERT INTO PRICE VALUES('TOYOTA ALTIS', 1250);
INSERT INTO PRICE VALUES('NISSAN MARCH', 2000);
INSERT INTO PRICE VALUES('KIA carnival', 2500);
INSERT INTO PRICE VALUES('TOYOTA PREVIA', 2600);
INSERT INTO PRICE VALUES('TOYOTA SIENNA Hybrid', 2700);
INSERT INTO PRICE VALUES('HYUNDAI STAREX', 2800);
INSERT INTO PRICE VALUES('TOYOTA ALPHARD', 2900);
INSERT INTO PRICE VALUES('Mercedes-Benz V250D', 3000);
INSERT INTO PRICE VALUES('Volkswagen CARAVELLE', 3100);
INSERT INTO PRICE VALUES('Mercedes-Benz VITO', 3200);
INSERT INTO PRICE VALUES('HONDA ODYSSEY', 3300);
INSERT INTO PRICE VALUES('HYUNDAI STARIA', 3400);
CREATE TABLE LOCATION (
  LOC_ID    INT AUTO_INCREMENT PRIMARY KEY,
  LOC_CITY  VARCHAR(200),
  LOC_ADDRESS VARCHAR(200)
);
INSERT INTO LOCATION VALUES(1, '台北市', '111台北市士林區至善路二段221號');
INSERT INTO LOCATION VALUES(2, '新北市', '221新北市汐止區建成路59巷2號');
INSERT INTO LOCATION VALUES(3, '桃園市', '320桃園市中壢區高鐵南路二段90號');
INSERT INTO LOCATION VALUES(4, '台中市', '408台中市南屯區向上路二段168號');
INSERT INTO LOCATION VALUES(5, '台南市', '744台南市新市區南科三路10號');
INSERT INTO LOCATION VALUES(6, '高雄市', '831高雄市大寮區進學路151號');
CREATE TABLE VEHICLE (
  VEH_ID    INT  AUTO_INCREMENT PRIMARY KEY,
  VEH_TYPE  VARCHAR(200),
  VEH_MODEL VARCHAR(30),
  LOC_ID    INT,
  FOREIGN KEY(LOC_ID) REFERENCES LOCATION(LOC_ID)
);
INSERT INTO VEHICLE VALUES('1111', '轎車', 'TOYOTA YARIS', 1);
INSERT INTO VEHICLE VALUES('1112', '轎車', 'TOYOTA YARIS', 1);
INSERT INTO VEHICLE VALUES('1113', '轎車', 'FORD KUGA', 1);
INSERT INTO VEHICLE VALUES('1114', '轎車', 'FORD KUGA', 1);
INSERT INTO VEHICLE VALUES('1115', '轎車', 'TOYOTA VIOS', 1);
INSERT INTO VEHICLE VALUES('1116', '轎車', 'TOYOTA VIOS', 1);
INSERT INTO VEHICLE VALUES('1117', '轎車', 'TOYOTA ALTIS', 1);
INSERT INTO VEHICLE VALUES('1118', '轎車', 'TOYOTA ALTIS', 1);
INSERT INTO VEHICLE VALUES('1119', '轎車', 'NISSAN MARCH', 1);
INSERT INTO VEHICLE VALUES('1120', '轎車', 'NISSAN MARCH', 1);
INSERT INTO VEHICLE VALUES('1121', '轎車', 'TOYOTA YARIS', 2);
INSERT INTO VEHICLE VALUES('1122', '轎車', 'TOYOTA YARIS', 2);
INSERT INTO VEHICLE VALUES('1123', '轎車', 'FORD KUGA', 2);
INSERT INTO VEHICLE VALUES('1124', '轎車', 'FORD KUGA', 2);
INSERT INTO VEHICLE VALUES('1125', '轎車', 'TOYOTA VIOS', 2);
INSERT INTO VEHICLE VALUES('1126', '轎車', 'TOYOTA VIOS', 2);
INSERT INTO VEHICLE VALUES('1127', '轎車', 'TOYOTA ALTIS', 2);
INSERT INTO VEHICLE VALUES('1128', '轎車', 'TOYOTA ALTIS', 2);
INSERT INTO VEHICLE VALUES('1129', '轎車', 'NISSAN MARCH', 2);
INSERT INTO VEHICLE VALUES('1130', '轎車', 'NISSAN MARCH', 2);
INSERT INTO VEHICLE VALUES('1131', '轎車', 'TOYOTA YARIS', 3);
INSERT INTO VEHICLE VALUES('1132', '轎車', 'TOYOTA YARIS', 3);
INSERT INTO VEHICLE VALUES('1133', '轎車', 'FORD KUGA', 3);
INSERT INTO VEHICLE VALUES('1134', '轎車', 'FORD KUGA', 3);
INSERT INTO VEHICLE VALUES('1135', '轎車', 'TOYOTA VIOS', 3);
INSERT INTO VEHICLE VALUES('1136', '轎車', 'TOYOTA VIOS', 3);
INSERT INTO VEHICLE VALUES('1137', '轎車', 'TOYOTA ALTIS', 3);
INSERT INTO VEHICLE VALUES('1138', '轎車', 'TOYOTA ALTIS', 3);
INSERT INTO VEHICLE VALUES('1139', '轎車', 'NISSAN MARCH', 3);
INSERT INTO VEHICLE VALUES('1140', '轎車', 'NISSAN MARCH', 3);
INSERT INTO VEHICLE VALUES('1141', '轎車', 'TOYOTA YARIS', 4);
INSERT INTO VEHICLE VALUES('1142', '轎車', 'TOYOTA YARIS', 4);
INSERT INTO VEHICLE VALUES('1143', '轎車', 'FORD KUGA', 4);
INSERT INTO VEHICLE VALUES('1144', '轎車', 'FORD KUGA', 4);
INSERT INTO VEHICLE VALUES('1145', '轎車', 'TOYOTA VIOS', 4);
INSERT INTO VEHICLE VALUES('1146', '轎車', 'TOYOTA VIOS', 4);
INSERT INTO VEHICLE VALUES('1147', '轎車', 'TOYOTA ALTIS', 4);
INSERT INTO VEHICLE VALUES('1148', '轎車', 'TOYOTA ALTIS', 4);
INSERT INTO VEHICLE VALUES('1149', '轎車', 'NISSAN MARCH', 4);
INSERT INTO VEHICLE VALUES('1150', '轎車', 'NISSAN MARCH', 4);
INSERT INTO VEHICLE VALUES('1151', '轎車', 'TOYOTA YARIS', 5);
INSERT INTO VEHICLE VALUES('1152', '轎車', 'TOYOTA YARIS', 5);
INSERT INTO VEHICLE VALUES('1153', '轎車', 'FORD KUGA', 5);
INSERT INTO VEHICLE VALUES('1154', '轎車', 'FORD KUGA', 5);
INSERT INTO VEHICLE VALUES('1155', '轎車', 'TOYOTA VIOS', 5);
INSERT INTO VEHICLE VALUES('1156', '轎車', 'TOYOTA VIOS', 5);
INSERT INTO VEHICLE VALUES('1157', '轎車', 'TOYOTA ALTIS', 5);
INSERT INTO VEHICLE VALUES('1158', '轎車', 'TOYOTA ALTIS', 5);
INSERT INTO VEHICLE VALUES('1159', '轎車', 'NISSAN MARCH', 5);
INSERT INTO VEHICLE VALUES('1160', '轎車', 'NISSAN MARCH', 5);
INSERT INTO VEHICLE VALUES('1161', '轎車', 'TOYOTA YARIS', 6);
INSERT INTO VEHICLE VALUES('1162', '轎車', 'TOYOTA YARIS', 6);
INSERT INTO VEHICLE VALUES('1163', '轎車', 'FORD KUGA', 6);
INSERT INTO VEHICLE VALUES('1164', '轎車', 'FORD KUGA', 6);
INSERT INTO VEHICLE VALUES('1165', '轎車', 'TOYOTA VIOS', 6);
INSERT INTO VEHICLE VALUES('1166', '轎車', 'TOYOTA VIOS', 6);
INSERT INTO VEHICLE VALUES('1167', '轎車', 'TOYOTA ALTIS', 6);
INSERT INTO VEHICLE VALUES('1168', '轎車', 'TOYOTA ALTIS', 6);
INSERT INTO VEHICLE VALUES('1169', '轎車', 'NISSAN MARCH', 6);
INSERT INTO VEHICLE VALUES('1170', '轎車', 'NISSAN MARCH', 6);
INSERT INTO VEHICLE VALUES('1171', '休旅車', 'KIA carnival', 1);
INSERT INTO VEHICLE VALUES('1172', '休旅車', 'KIA carnival', 1);
INSERT INTO VEHICLE VALUES('1173', '休旅車', 'TOYOTA PREVIA', 1);
INSERT INTO VEHICLE VALUES('1174', '休旅車', 'TOYOTA PREVIA', 1);
INSERT INTO VEHICLE VALUES('1175', '休旅車', 'TOYOTA SIENNA Hybrid', 1);
INSERT INTO VEHICLE VALUES('1176', '休旅車', 'TOYOTA SIENNA Hybrid', 1);
INSERT INTO VEHICLE VALUES('1177', '休旅車', 'HYUNDAI STAREX', 1);
INSERT INTO VEHICLE VALUES('1178', '休旅車', 'HYUNDAI STAREX', 1);
INSERT INTO VEHICLE VALUES('1179', '休旅車', 'TOYOTA ALPHARD', 1);
INSERT INTO VEHICLE VALUES('1180', '休旅車', 'TOYOTA ALPHARD', 1);
INSERT INTO VEHICLE VALUES('1181', '休旅車', 'KIA carnival', 2);
INSERT INTO VEHICLE VALUES('1182', '休旅車', 'KIA carnival', 2);
INSERT INTO VEHICLE VALUES('1183', '休旅車', 'TOYOTA PREVIA', 2);
INSERT INTO VEHICLE VALUES('1184', '休旅車', 'TOYOTA PREVIA', 2);
INSERT INTO VEHICLE VALUES('1185', '休旅車', 'TOYOTA SIENNA Hybrid', 2);
INSERT INTO VEHICLE VALUES('1186', '休旅車', 'TOYOTA SIENNA Hybrid', 2);
INSERT INTO VEHICLE VALUES('1187', '休旅車', 'HYUNDAI STAREX', 2);
INSERT INTO VEHICLE VALUES('1188', '休旅車', 'HYUNDAI STAREX', 2);
INSERT INTO VEHICLE VALUES('1189', '休旅車', 'TOYOTA ALPHARD', 2);
INSERT INTO VEHICLE VALUES('1190', '休旅車', 'TOYOTA ALPHARD', 2);
INSERT INTO VEHICLE VALUES('1191', '休旅車', 'KIA carnival', 3);
INSERT INTO VEHICLE VALUES('1192', '休旅車', 'KIA carnival', 3);
INSERT INTO VEHICLE VALUES('1193', '休旅車', 'TOYOTA PREVIA', 3);
INSERT INTO VEHICLE VALUES('1194', '休旅車', 'TOYOTA PREVIA', 3);
INSERT INTO VEHICLE VALUES('1195', '休旅車', 'TOYOTA SIENNA Hybrid', 3);
INSERT INTO VEHICLE VALUES('1196', '休旅車', 'TOYOTA SIENNA Hybrid', 3);
INSERT INTO VEHICLE VALUES('1197', '休旅車', 'HYUNDAI STAREX', 3);
INSERT INTO VEHICLE VALUES('1198', '休旅車', 'HYUNDAI STAREX', 3);
INSERT INTO VEHICLE VALUES('1199', '休旅車', 'TOYOTA ALPHARD', 3);
INSERT INTO VEHICLE VALUES('1200', '休旅車', 'TOYOTA ALPHARD', 3);
INSERT INTO VEHICLE VALUES('1201', '休旅車', 'KIA carnival', 4);
INSERT INTO VEHICLE VALUES('1202', '休旅車', 'KIA carnival', 4);
INSERT INTO VEHICLE VALUES('1203', '休旅車', 'TOYOTA PREVIA', 4);
INSERT INTO VEHICLE VALUES('1204', '休旅車', 'TOYOTA PREVIA', 4);
INSERT INTO VEHICLE VALUES('1205', '休旅車', 'TOYOTA SIENNA Hybrid', 4);
INSERT INTO VEHICLE VALUES('1206', '休旅車', 'TOYOTA SIENNA Hybrid', 4);
INSERT INTO VEHICLE VALUES('1207', '休旅車', 'HYUNDAI STAREX', 4);
INSERT INTO VEHICLE VALUES('1208', '休旅車', 'HYUNDAI STAREX', 4);
INSERT INTO VEHICLE VALUES('1209', '休旅車', 'TOYOTA ALPHARD', 4);
INSERT INTO VEHICLE VALUES('1210', '休旅車', 'TOYOTA ALPHARD', 4);
INSERT INTO VEHICLE VALUES('1211', '休旅車', 'KIA carnival', 5);
INSERT INTO VEHICLE VALUES('1212', '休旅車', 'KIA carnival', 5);
INSERT INTO VEHICLE VALUES('1213', '休旅車', 'TOYOTA PREVIA', 5);
INSERT INTO VEHICLE VALUES('1214', '休旅車', 'TOYOTA PREVIA', 5);
INSERT INTO VEHICLE VALUES('1215', '休旅車', 'TOYOTA SIENNA Hybrid', 5);
INSERT INTO VEHICLE VALUES('1216', '休旅車', 'TOYOTA SIENNA Hybrid', 5);
INSERT INTO VEHICLE VALUES('1217', '休旅車', 'HYUNDAI STAREX', 5);
INSERT INTO VEHICLE VALUES('1218', '休旅車', 'HYUNDAI STAREX', 5);
INSERT INTO VEHICLE VALUES('1219', '休旅車', 'TOYOTA ALPHARD', 5);
INSERT INTO VEHICLE VALUES('1220', '休旅車', 'TOYOTA ALPHARD', 5);
INSERT INTO VEHICLE VALUES('1221', '休旅車', 'KIA carnival', 6);
INSERT INTO VEHICLE VALUES('1222', '休旅車', 'KIA carnival', 6);
INSERT INTO VEHICLE VALUES('1223', '休旅車', 'TOYOTA PREVIA', 6);
INSERT INTO VEHICLE VALUES('1224', '休旅車', 'TOYOTA PREVIA', 6);
INSERT INTO VEHICLE VALUES('1225', '休旅車', 'TOYOTA SIENNA Hybrid', 6);
INSERT INTO VEHICLE VALUES('1226', '休旅車', 'TOYOTA SIENNA Hybrid', 6);
INSERT INTO VEHICLE VALUES('1227', '休旅車', 'HYUNDAI STAREX', 6);
INSERT INTO VEHICLE VALUES('1228', '休旅車', 'HYUNDAI STAREX', 6);
INSERT INTO VEHICLE VALUES('1229', '休旅車', 'TOYOTA ALPHARD', 6);
INSERT INTO VEHICLE VALUES('1230', '休旅車', 'TOYOTA ALPHARD', 6);
INSERT INTO VEHICLE VALUES('1231', '箱型車', 'Mercedes-Benz V250D', 1);
INSERT INTO VEHICLE VALUES('1232', '箱型車', 'Mercedes-Benz V250D', 1);
INSERT INTO VEHICLE VALUES('1233', '箱型車', 'Volkswagen CARAVELLE', 1);
INSERT INTO VEHICLE VALUES('1234', '箱型車', 'Volkswagen CARAVELLE', 1);
INSERT INTO VEHICLE VALUES('1235', '箱型車', 'Mercedes-Benz VITO', 1);
INSERT INTO VEHICLE VALUES('1236', '箱型車', 'Mercedes-Benz VITO', 1);
INSERT INTO VEHICLE VALUES('1237', '箱型車', 'HONDA ODYSSEY', 1);
INSERT INTO VEHICLE VALUES('1238', '箱型車', 'HONDA ODYSSEY', 1);
INSERT INTO VEHICLE VALUES('1239', '箱型車', 'HYUNDAI STARIA', 1);
INSERT INTO VEHICLE VALUES('1240', '箱型車', 'HYUNDAI STARIA', 1);
INSERT INTO VEHICLE VALUES('1241', '箱型車', 'Mercedes-Benz V250D', 2);
INSERT INTO VEHICLE VALUES('1242', '箱型車', 'Mercedes-Benz V250D', 2);
INSERT INTO VEHICLE VALUES('1243', '箱型車', 'Volkswagen CARAVELLE', 2);
INSERT INTO VEHICLE VALUES('1244', '箱型車', 'Volkswagen CARAVELLE', 2);
INSERT INTO VEHICLE VALUES('1245', '箱型車', 'Mercedes-Benz VITO', 2);
INSERT INTO VEHICLE VALUES('1246', '箱型車', 'Mercedes-Benz VITO', 2);
INSERT INTO VEHICLE VALUES('1247', '箱型車', 'HONDA ODYSSEY', 2);
INSERT INTO VEHICLE VALUES('1248', '箱型車', 'HONDA ODYSSEY', 2);
INSERT INTO VEHICLE VALUES('1249', '箱型車', 'HYUNDAI STARIA', 2);
INSERT INTO VEHICLE VALUES('1250', '箱型車', 'HYUNDAI STARIA', 2);
INSERT INTO VEHICLE VALUES('1251', '箱型車', 'Mercedes-Benz V250D', 3);
INSERT INTO VEHICLE VALUES('1252', '箱型車', 'Mercedes-Benz V250D', 3);
INSERT INTO VEHICLE VALUES('1253', '箱型車', 'Volkswagen CARAVELLE', 3);
INSERT INTO VEHICLE VALUES('1254', '箱型車', 'Volkswagen CARAVELLE', 3);
INSERT INTO VEHICLE VALUES('1255', '箱型車', 'Mercedes-Benz VITO', 3);
INSERT INTO VEHICLE VALUES('1256', '箱型車', 'Mercedes-Benz VITO', 3);
INSERT INTO VEHICLE VALUES('1257', '箱型車', 'HONDA ODYSSEY', 3);
INSERT INTO VEHICLE VALUES('1258', '箱型車', 'HONDA ODYSSEY', 3);
INSERT INTO VEHICLE VALUES('1259', '箱型車', 'HYUNDAI STARIA', 3);
INSERT INTO VEHICLE VALUES('1260', '箱型車', 'HYUNDAI STARIA', 3);
INSERT INTO VEHICLE VALUES('1261', '箱型車', 'Mercedes-Benz V250D', 4);
INSERT INTO VEHICLE VALUES('1262', '箱型車', 'Mercedes-Benz V250D', 4);
INSERT INTO VEHICLE VALUES('1263', '箱型車', 'Volkswagen CARAVELLE', 4);
INSERT INTO VEHICLE VALUES('1264', '箱型車', 'Volkswagen CARAVELLE', 4);
INSERT INTO VEHICLE VALUES('1265', '箱型車', 'Mercedes-Benz VITO', 4);
INSERT INTO VEHICLE VALUES('1266', '箱型車', 'Mercedes-Benz VITO', 4);
INSERT INTO VEHICLE VALUES('1267', '箱型車', 'HONDA ODYSSEY', 4);
INSERT INTO VEHICLE VALUES('1268', '箱型車', 'HONDA ODYSSEY', 4);
INSERT INTO VEHICLE VALUES('1269', '箱型車', 'HYUNDAI STARIA', 4);
INSERT INTO VEHICLE VALUES('1270', '箱型車', 'HYUNDAI STARIA', 4);
INSERT INTO VEHICLE VALUES('1271', '箱型車', 'Mercedes-Benz V250D', 5);
INSERT INTO VEHICLE VALUES('1272', '箱型車', 'Mercedes-Benz V250D', 5);
INSERT INTO VEHICLE VALUES('1273', '箱型車', 'Volkswagen CARAVELLE', 5);
INSERT INTO VEHICLE VALUES('1274', '箱型車', 'Volkswagen CARAVELLE', 5);
INSERT INTO VEHICLE VALUES('1275', '箱型車', 'Mercedes-Benz VITO', 5);
INSERT INTO VEHICLE VALUES('1276', '箱型車', 'Mercedes-Benz VITO', 5);
INSERT INTO VEHICLE VALUES('1277', '箱型車', 'HONDA ODYSSEY', 5);
INSERT INTO VEHICLE VALUES('1278', '箱型車', 'HONDA ODYSSEY', 5);
INSERT INTO VEHICLE VALUES('1279', '箱型車', 'HYUNDAI STARIA', 5);
INSERT INTO VEHICLE VALUES('1280', '箱型車', 'HYUNDAI STARIA', 5);
INSERT INTO VEHICLE VALUES('1281', '箱型車', 'Mercedes-Benz V250D', 6);
INSERT INTO VEHICLE VALUES('1282', '箱型車', 'Mercedes-Benz V250D', 6);
INSERT INTO VEHICLE VALUES('1283', '箱型車', 'Volkswagen CARAVELLE', 6);
INSERT INTO VEHICLE VALUES('1284', '箱型車', 'Volkswagen CARAVELLE', 6);
INSERT INTO VEHICLE VALUES('1285', '箱型車', 'Mercedes-Benz VITO', 6);
INSERT INTO VEHICLE VALUES('1286', '箱型車', 'Mercedes-Benz VITO', 6);
INSERT INTO VEHICLE VALUES('1287', '箱型車', 'HONDA ODYSSEY', 6);
INSERT INTO VEHICLE VALUES('1288', '箱型車', 'HONDA ODYSSEY', 6);
INSERT INTO VEHICLE VALUES('1289', '箱型車', 'HYUNDAI STARIA', 6);
INSERT INTO VEHICLE VALUES('1290', '箱型車', 'HYUNDAI STARIA', 6);
CREATE TABLE RENT (
  CUS_IDNUM      VARCHAR(10),
  REN_ID         VARCHAR(10) PRIMARY KEY,
  VEH_ID         INT AUTO_INCREMENT,
  REN_STARTLOC   INT,
  REN_ENDLOC     INT,
  REN_PRICE      DECIMAL(10,2),
  REN_PAYMENT    VARCHAR(200),
  REN_PAID       VARCHAR(200),
  REN_PICKUP_CONDITION  VARCHAR(200),
  REN_RETURN_CONDITION  VARCHAR(200),
  REN_CANCEL  VARCHAR(200),
  REN_STARTDATE  DATE,
  REN_STARTTIME  VARCHAR(200),
  REN_ENDDATE    DATE,
  REN_ENDTIME    VARCHAR(200),
  FOREIGN KEY (CUS_IDNUM) REFERENCES CUSTOMER(CUS_IDNUM),
  FOREIGN KEY (VEH_ID) REFERENCES VEHICLE(VEH_ID),
  FOREIGN KEY (REN_STARTLOC) REFERENCES LOCATION(LOC_ID),
  FOREIGN KEY (REN_ENDLOC) REFERENCES LOCATION(LOC_ID)
);
INSERT INTO RENT VALUES(
  'H225871103', '1001', '1111', 4, 6, 2400.00,
  '信用卡', '已付款', '已取車','已還車' ,'已取消','2024-06-12', '10:00',
  '2024-06-14', '10:00'
);
INSERT INTO RENT VALUES(
  'H225902416', '1002', '1111', 1, 1, 2400.00,
  '信用卡', '已付款', '已取車','已還車' ,'已取消','2024-06-12', '08:00',
  '2024-06-14', '08:00'
);
INSERT INTO RENT VALUES(
  'B223380210', '1003', '1111', 1, 1, 2400.00,
  '信用卡', '未付款', '未取車','已還車' ,'未取消', '2024-06-15', '08:00',
  '2024-06-17', '08:00'
);
INSERT INTO RENT VALUES(
  'C123456789', '1004', '1113', 2, 2, 2600.00,
  '現金', '未付款', '已取車','已還車' ,'未取消', '2024-06-16', '09:00',
  '2024-06-18', '09:00'
);
INSERT INTO RENT VALUES(
  'D987654321', '1005', '1114', 3, 3, 2500.00,
  '信用卡', '已付款', '已取車', '已還車' ,'未取消','2024-06-14', '10:00',
  '2024-06-16', '10:00'
);
INSERT INTO RENT VALUES(
  'B223380210', '1007', '1111', 1, 1, 2400.00,
  '信用卡', '已付款', '未取車','未還車' ,'未取消', '2024-07-15', '08:00',
  '2024-07-17', '08:00'
);
INSERT INTO RENT VALUES(
  'S225393488', '1006', '1111', 1, 1, 2400.00,
  '信用卡', '已付款', '已取車','已還車' ,'未取消', '2024-07-15', '08:00',
  '2024-07-17', '08:00'
);
INSERT INTO RENT VALUES(
  'H225902416', '1008', '1111', 3, 4, 2400.00,
  '信用卡', '已付款', '未取車','未還車' ,'未取消', '2024-07-15', '08:00',
  '2024-07-17', '08:00'
);
INSERT INTO RENT VALUES(
  'H225902416', '1009', '1111', 2, 2, 2400.00,
  '信用卡', '已付款', '已取車','未還車' ,'未取消', '2024-07-15', '08:00',
  '2024-07-17', '08:00'
);
INSERT INTO RENT VALUES(
  'H225902416', '1010', '1111', 1, 1, 2400.00,
  '信用卡', '未付款', '未取車','已還車' ,'未取消', '2024-06-15', '08:00',
  '2024-06-17', '08:00'
);


CREATE TABLE FEEDBACK (
  CUS_IDNUM   VARCHAR(10) PRIMARY KEY,
  REN_ID      VARCHAR(10),
  FEE_SCORE   INT,
  FEE_COMMENT VARCHAR(200),
  FEE_DATE    VARCHAR(200)
);
INSERT INTO FEEDBACK VALUES('H225871103', '1001', 4, '使用車子的體驗不錯，之後會再來租車', '2024-06-12');
INSERT INTO FEEDBACK VALUES('B223380210', '1003', 2, '車子有點問題，會發出很大的噪音', '2024-06-13');
INSERT INTO FEEDBACK VALUES('C123456789', '1004', 5, '非常滿意，車況很好', '2024-06-16');
INSERT INTO FEEDBACK VALUES('D987654321', '1005', 3, '車子還可以，有點小問題', '2024-06-14');
INSERT INTO FEEDBACK VALUES('S225393488', '1008', 3, '車子還可以，有點小問題', '2024-06-14');



CREATE TABLE QUESTION(
 QUE_NUM  INT AUTO_INCREMENT PRIMARY KEY,
  CUS_IDNUM     VARCHAR(10),
  QUE_QUESTION VARCHAR(700),
 FOREIGN KEY (CUS_IDNUM) REFERENCES CUSTOMER(CUS_IDNUM)
   );

INSERT INTO QUESTION VALUES('1','B223380210','請問當月生日會打折嗎?');
INSERT INTO QUESTION VALUES('2','H225871103','請問有哪些轎跑車可以租?');



CREATE TABLE ANSWER(
 QUE_NUM   INT AUTO_INCREMENT  PRIMARY KEY,
  ADM_IDNUM     VARCHAR(10),
  ANS_ANSWER VARCHAR(700),
FOREIGN KEY (  QUE_NUM ) REFERENCES QUESTION(  QUE_NUM ),
 FOREIGN KEY ( ADM_IDNUM) REFERENCES ADMIN( ADM_IDNUM)
   );


INSERT INTO ANSWER  VALUES('1','A000000000','目前沒有提供生日優惠服務喔!');
INSERT INTO ANSWER VALUES('2','B111111111','EASY RENT有提供2~3種轎跑車款式，詳情請見官網。');

```
