var baseUrl = $('#baseUrl').val();
var array = [
	{name: "vehiclecategory", value: baseUrl + "vehicle/categorySubmit"},
	{name: "vehicle", value: baseUrl + "vehicle/vehicleSubmit"},
	{name: "vehicleList", value: baseUrl + "vehicle/vehicleDelete"},
	{name: "vehicle_update", value: baseUrl + "vehicle/vehicleUpdate"},
	{name: "vehicleList", value: baseUrl + "vehicle/vehicleDelete"},
	{name: "vehicle-detail-view", value: baseUrl + "vehicle/vehicleDetails"},
	{name: "labourmaster", value: baseUrl + "labour/labourMasterSubmit"},
	{name: "labourList", value: baseUrl + "labour/labourDelete"},
	{name: "labour_update", value: baseUrl + "labour/labourUpdate"},
	{name: "vendormaster", value: baseUrl + "vendor/addvendor"},
	{name: "vendorList", value: baseUrl + "vendor/vendorDelete"},
	{name: "vendor_update", value: baseUrl + "vendor/vendorUpdate"},
	{name: "contractormaster", value: baseUrl + "contractor/addcontractor"},
	{name: "contractorList", value: baseUrl + "contractor/contractorDelete"},
	{name: "contractor_update", value: baseUrl + "contractor/contractorUpdate"},
	{name: "useradd", value: baseUrl + "user/adduser"},
	{name: "user_update", value: baseUrl + "user/Userupdate"},
	{name: "userList", value: baseUrl + "user/userDelete"},
	{name: "bookingmaster", value: baseUrl + "booking/addbooking"},
	{name: "booking_update", value: baseUrl + "booking/Bookingupdate"},
	{name: "bookingList", value: baseUrl + "booking/bookingDelete"},
	{name: "passenger-detail-view", value: baseUrl + "booking/passengerList"},
	{name: "customermaster", value: baseUrl + "customer/addcustomer"},
	{name: "customerUpdate", value: baseUrl + "customer/customerUpdate"},
	{name: "dutySlip", value: baseUrl + "booking/addDutySlip"},
	{name: "updateDutySlip", value: baseUrl + "booking/updateDuty"},
	{name: "passenger-detail-delete", value: baseUrl + "booking/passengerDelete"},
	{name: "login", value: baseUrl + "login/loginAction"},
	{name: "labourattn", value: baseUrl + "labour/labourAttnSubmit"},
	{name: "holiday", value: baseUrl + "company/addHoliday"},
	{name: "holidayList", value: baseUrl + "company/holidayDelete"},
	{name: "attendanceReport", value: baseUrl + "labour/attnReport"},
	{name: "expensemaster", value: baseUrl + "payment/expenseMasterSubmit"},
	{name: "advancesalarymaster", value: baseUrl + "payment/advancesalaryMasterSubmit"},
	{name: "insertaccount", value: baseUrl + "account/accountSubmit"},
	{name: "updateaccount", value: baseUrl + "account/accountUpdate"},
	{name: "accountList", value: baseUrl + "account/accountDelete"},
	{name: "addamount", value: baseUrl + "account/addAmountSubmit"},
	{name: "addamount", value: baseUrl + "account/addAmountSubmit"},
	{name: "transactionList", value: baseUrl + "account/transactionDelete"},
	{name: "editTransaction", value: baseUrl + "account/transactionEdit"},
	{name: "profit_and_loss", value: baseUrl + "account/profit_and_loss"},
	{name: "journalvoucher", value: baseUrl + "payment/journalentrySubmit"},
	{name: "package", value: baseUrl + "package/addPackage"},
	{name: "package_update", value: baseUrl + "package/updatePackage"},
	{name: "package-List-booking", value: baseUrl + "package/packageListBooking"},
	{name: "addgroup", value: baseUrl + "account/addgroupSubmit"},
	{name: "ledList", value: baseUrl + "account/disableLedger"},
	{name: "grpList", value: baseUrl + "account/disableGroup"},
	{name: "editgroup", value: baseUrl + "account/updateGroup"},
	{name: "invoicePaid", value: baseUrl + "invoice/invoicePaidSubmit"},
	{name: "get-driver-sal", value: baseUrl + "payment/getDriverSal"},
	{name: "sal-paid", value: baseUrl + "payment/salPaid"},
	{name: "siteadd", value: baseUrl + "site/addsite"},
	{name: "siteList", value: baseUrl + "site/siteDelete"},
	{name: "site_update", value: baseUrl + "site/siteUpdate"},
	{name: "staffmaster", value: baseUrl + "staff/addstaff"},
	{name: "staffList", value: baseUrl + "staff/staffDelete"},
	{name: "staffatten", value: baseUrl + "staff/staffAttnSubmit"},
	{name: "staff_update", value: baseUrl + "staff/staffUpdate"},
	{name: "staffPaymaster", value: baseUrl + "staff/PaymentAdd"},
	{name: "staff_payupdate", value: baseUrl + "staff/staffUpdate"},
	{name: "staffattendanceReport", value: baseUrl + "staff/attnReport"},
	{name: "get_slab_det", value: baseUrl + "account/slab_list"},
	{name: "productAdd", value: baseUrl + "inventory/addItem"},
	{name: "productUpdate", value: baseUrl + "inventory/productUpdate"},
	{name: "product_details", value: baseUrl + "inventory/productDetails"},
	{name: "inward_submit", value: baseUrl + "inventory/inwardSubmit"},
	{name: "outward_submit", value: baseUrl + "inventory/outwardSubmit"},
	{name: "billpayment", value: baseUrl+"vendor/billPayment"},
	
	

	
	
	
];

