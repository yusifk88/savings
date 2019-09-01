<template>
    <div>
    <v-card class="overflow-hidden">
        <v-app-bar
            absolute
            color="green darken-4"
            dark
            shrink-on-scroll
            prominent
            src="https://picsum.photos/1920/1080?random"
            fade-img-on-scroll
            scroll-target="#scrolling-techniques-3"
        >
            <template v-slot:img="{ props }">
                <v-img
                    v-bind="props"
                    gradient="to top right, rgba(100,255,201,.4), rgba(0,255,0,.1)"
                ></v-img>
            </template>
           <p>
               <v-toolbar-title>{{account.fname+" "+account.lname}} <span class="yellow--text">GHs {{balance}}.00</span></v-toolbar-title>
           </p>
            <v-toolbar-title class="ml-3">  <v-icon>phone</v-icon> {{account.phone}} | <v-icon>mail</v-icon> {{account.email}}  </v-toolbar-title>


            <div class="flex-grow-1"></div>

            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                    <v-btn @click="editDlg = true" icon v-on="on">
                        <v-icon>mdi-account-edit</v-icon>
                    </v-btn>
                </template>
                <span>Edit Account</span>
            </v-tooltip>


            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on" @click="addCont">
                        <v-icon>mdi-bank-plus</v-icon>
                    </v-btn>
                </template>
                <span>Receive Contribution</span>
            </v-tooltip>

            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on">
                        <v-icon>print</v-icon>
                    </v-btn>
                </template>
                <span>Print Statements</span>
            </v-tooltip>


            <template v-slot:extension>
                <v-tabs
                    align-with-title
                    background-color="transparent"
                    v-model="accountTabs"
                    centered
                >

                    <v-tab href="#info">Account Info.</v-tab>
                    <v-tab href="#pay">Contributions</v-tab>
                    <v-tab href="#loans">Loans</v-tab>
                </v-tabs>

            </template>

            <v-btn icon>
                <v-icon>more_vert</v-icon>
            </v-btn>


        </v-app-bar>
        <v-sheet
            id="scrolling-techniques-3"
            class="overflow-y-auto"
            max-height="600"
        >
            <v-container style="height: 1000px; margin-top: 200px;">
                <v-tabs-items
                    v-model="accountTabs"
                >


                    <v-tab-item
                        :value="infoTab"
                        :key="1"
                    >


                        <v-card flat tile>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" sm="4">
                                    <v-img
                                       :src="account.passport"
                                       :lazy-src="account.passport"
                                       class="green lighten-2"
                                       max-with="400"
                                       max-height="600"
                                    >

                                    </v-img>
                                    </v-col>
                                    <v-col cols="12" sm="8">
                                        <h2 class="red--text darken-4 ">GHs {{balance}}.00</h2>
                                        Current Balance
                                        <h3>{{account.title}}</h3>
                                        Title

                                       <h3>{{account.fname}} {{account.lname}}</h3>
                                        Full Name

                                        <h3>{{account.sex}}</h3>
                                        Sex

                                        <h3>{{account.hometown}}</h3>
                                        Hometown
                                        <h3>{{account.phone}}</h3>
                                        Phone Number

                                        <h3>{{account.address}}</h3>
                                        Address
                                        <h3>{{account.occupation}}</h3>
                                        Occupation

                                        <h3>{{account.dob | humanDate}}</h3>
                                        Birth Date

                                        <h3>{{account.email}}</h3>

                                        E-Mail Address
                                        <h3>{{account.bank}}</h3>
                                        Bank Name
                                        <h3>{{account.accno}}</h3>
                                        Bank Account Number


                                    </v-col>

                                </v-row>

                            </v-card-text>

                        </v-card>


                    </v-tab-item>

                    <v-tab-item
                        :value="payTab"
                        :key="2"
                    >

                        <v-card flat tile>
                            <v-card-text>

                                <v-text-field
                                    v-model="search"
                                    append-icon="search"
                                    single-line
                                    hide-details
                                    label="Search"
                                    color="success"
                                >
                                </v-text-field>

                                <v-data-table
                                    :headers="headers"
                                    :items="contributions"
                                    :items-per-page=20
                                    :search="search"
                                    :loading='loading'

                                >
                                    <template v-slot:item.payment_date="{ item }">
                                        {{item.payment_date | humanDate}}
                                    </template>

                                    <template v-slot:item.actions="{ item }">

                                        <v-btn text color="red" @click="delCont(item)">Delete</v-btn>

                                    </template>

                                </v-data-table>
                            </v-card-text>
                        </v-card>

                    </v-tab-item>
                    <v-tab-item
                        :value="loansTab"
                        :key="3"
                    >

                        <v-card flat tile>
                            <v-card-text>
                                <h2>loans tab</h2>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
        </v-tabs-items>
            </v-container>
        </v-sheet>
    </v-card>

    <v-overlay
        :value="progress"
        :absolute="absolute"
        :light="light"
        :z-index="zindex"
    >

        <v-progress-circular
            :size="70"
            :width="4"
            color="white"
            indeterminate
        ></v-progress-circular>

    </v-overlay>
        <v-row justify="center">
            <v-dialog persistent v-model="netDlg" max-width="40%">

                <v-card>
                    <v-card-title class="headline red--text">Network Error</v-card-title>
                    <v-card-text>
                        <h4 color="'red--text">
                            <v-icon color="red--text">warning</v-icon> Could not reach the server, please check your network and try again
                        </h4>
                    </v-card-text>
                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn color="green darken-1" text @click="getaccount">Retry</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>

        <v-row justify="center">
            <v-dialog v-model="contDlg" max-width="80%">
                <v-card>
                    <v-card-text>

                        <v-row>
                            <v-col cols="12" sm="4">
                                <v-img
                                    :src="account.passport"
                                    max-width="400px"
                                    >
                                </v-img>
                                <h3>Name: {{account.fname}} {{account.lname}}</h3>
                                <h3>Phone Number: {{account.phone}}</h3>
                                <h3>E-Mail: {{account.phone}}</h3>
                                <v-switch
                                    v-model="notify"
                                    color="green darken-4"
                                    label="Notify Via SMS"
                                ></v-switch>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="8"
                            >
                                <v-form ref="contForm" v-model="validForm">

                                    <v-text-field
                                        v-model="amount"
                                        :rules="amountRules"
                                        label = "amount"
                                        type="number"
                                        prepend-inner-icon="mdi-cash"
                                    >

                                    </v-text-field>
                                    <v-select
                                        :items="purposes"
                                        label="Category"
                                        :rules="purposeRules"
                                        color = "green"
                                        items-color="green"
                                        v-model="purpose"
                                        prepend-inner-icon="mdi-anchor"
                                    >


                                    </v-select>
                                </v-form>
                                <v-dialog
                                    ref="dialog"
                                    v-model="dmodal"
                                    :return-value.sync="dentry"
                                    persistent
                                    full-width
                                    width="290px"
                                >
                                <template v-slot:activator="{ on }">
                                        <v-text-field
                                            v-model="dentry"
                                            label="Select Date Of Entry"
                                            prepend-icon="event"
                                            readonly
                                            v-on="on"
                                            :rules="dRules"
                                        >

                                        </v-text-field>
                                    </template>
                                    <v-date-picker v-model="dentry" scrollable>
                                        <div class="flex-grow-1"></div>
                                        <v-btn text color="success" @click="dmodal = false">Cancel</v-btn>
                                        <v-btn text color="success" @click="$refs.dialog.save(dentry)">OK</v-btn>
                                    </v-date-picker>
                                </v-dialog>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn color="green darken-1" text @click="saveCont">Save</v-btn>
                        <v-btn color="red darken-1" text @click="contDlg = false">Cancel</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>

        <v-row justify="center">
            <v-dialog v-model="netDlg" persistent max-width="40%">

                <v-card>
                    <v-card-title class="headline red--text">Network Error</v-card-title>
                    <v-card-text>
                        <h4 color="'red--text">
                            <v-icon color="red--text">warning</v-icon> Could not reach the server, please check your
                            network and try again
                        </h4>
                    </v-card-text>
                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn color="green darken-1" text @click="getaccount">Retry</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>



        <v-row justify="center">
            <v-dialog v-model="editDlg" persistent max-width="90%">

                <v-card>
                    <v-card-title class="headline green--text darken-4">Edit this Account</v-card-title>
                    <v-card-text>
                        <v-form
                            v-model="UpformValid"
                            ref="UpaccountForm"
                            enctype="multipart/form-data"
                        >
                            <v-container>
                                <v-row align="center">


                                    <v-col cols="12" sm="4">
                                        <v-select
                                            :items="titles"
                                            label="Title"
                                            cache-items
                                            prepend-icon="mdi-check"
                                            color="success"
                                            item-color="success"
                                            required
                                            :rules="titleRules"
                                            v-model="upaccount.title"

                                        >

                                        </v-select>

                                    </v-col>

                                    <v-col cols="12" sm="4">
                                        <v-text-field
                                            label="First Name"
                                            prepend-icon="person"
                                            color="success"
                                            required
                                            :rules="nameRules"
                                            v-model="upaccount.fname"

                                        >

                                        </v-text-field>

                                    </v-col>

                                    <v-col cols="12" sm="4">
                                        <v-text-field
                                            label="Last Name"
                                            prepend-icon="person"
                                            color="success"
                                            required
                                            :rules="nameRules"
                                            v-model="upaccount.lname"

                                        >

                                        </v-text-field>

                                    </v-col>


                                    <v-col cols="12" sm="4">
                                        <v-select
                                            :items="sexList"
                                            label="Sex"
                                            cache-items
                                            prepend-icon="mdi-gender-male-female-variant"
                                            color="success"
                                            item-color="success"
                                            required
                                            :rules="sexRules"
                                            v-model="upaccount.sex"

                                        >

                                        </v-select>

                                    </v-col>
                                    <v-col cols="12" sm="4">
                                        <v-text-field
                                            label="Phone Number"
                                            prepend-icon="phone"
                                            color="success"
                                            required
                                            :rules="phoneRules"
                                            v-model="upaccount.phone"


                                        >

                                        </v-text-field>

                                    </v-col>


                                    <v-col cols="12" sm="4">
                                        <v-text-field
                                            label="Occupation"
                                            prepend-icon="mdi-briefcase"
                                            color="success"
                                            required
                                            :rules="occupationRules"
                                            v-model="upaccount.occupation"


                                        >

                                        </v-text-field>

                                    </v-col>

                                    <v-col cols="12" sm="6">
                                        <v-text-field
                                            label="Email Address"
                                            prepend-icon="mdi-at"
                                            color="success"
                                            required
                                            :rules="emailRules"
                                            v-model="upaccount.email"
                                        >

                                        </v-text-field>

                                    </v-col>


                                    <v-col cols="12" sm="6">
                                        <v-textarea
                                            name="'address"
                                            label="Address"
                                            prepend-icon="mdi-map-marker"
                                            color="success"
                                            required
                                            value=""
                                            hint="Permanent/Residential Address"
                                            :rules="addressRules"
                                            v-model="upaccount.address"


                                        >

                                        </v-textarea>

                                    </v-col>


                                    <v-col cols="12" sm="8">
                                        <v-text-field
                                            label="Hometown"
                                            prepend-icon="map"
                                            color="success"
                                            required
                                            :rules="hometownRules"
                                            v-model="upaccount.hometown"
                                        >

                                        </v-text-field>

                                    </v-col>


                                    <v-col cols="12" sm="4">
                                        <v-dialog
                                            ref="dialog"
                                            v-model="dobmodal"
                                            :return-value.sync="upaccount.dob"
                                            persistent
                                            full-width
                                            width="290px"
                                        >
                                            <template v-slot:activator="{ on }">
                                                <v-text-field
                                                    v-model="upaccount.dob"
                                                    label="Select Birth Date"
                                                    prepend-icon="event"
                                                    readonly
                                                    v-on="on"
                                                    :rules="upaccount.dobRules"
                                                >

                                                </v-text-field>
                                            </template>
                                            <v-date-picker v-model="upaccount.dob" scrollable>
                                                <div class="flex-grow-1"></div>
                                                <v-btn text color="success" @click="dobmodal = false">Cancel</v-btn>
                                                <v-btn text color="success" @click="$refs.dialog.save(upaccount.dob)">OK</v-btn>
                                            </v-date-picker>
                                        </v-dialog>


                                    </v-col>

                                    <v-col cols="12" sm="4">
                                        <v-text-field
                                            label="Bank Name"
                                            prepend-icon="mdi-bank"
                                            color="success"
                                            required
                                            :rules="bankRules"
                                            v-model="upaccount.bank"
                                        >

                                        </v-text-field>

                                    </v-col>

                                    <v-col cols="12" sm="4">
                                        <v-text-field
                                            label="Account Number"
                                            prepend-icon="mdi-account-details"
                                            color="success"
                                            required
                                            :rules="accnoRules"
                                            v-model="upaccount.accno"

                                        >

                                        </v-text-field>

                                    </v-col>
                                    <v-img
                                        :src="account.passport"
                                        :lazy-src="imgsrc"
                                        aspect-ratio="1"
                                        class="grey lighten-2"
                                        max-width="500"
                                        max-height="300"
                                    >

                                        <v-row
                                            class="fill-height ma-0"
                                            align="center"
                                            justify="center"
                                        >
                                            <v-progress-circular v-if="imageLoading" indeterminate color="green darken-5"></v-progress-circular>
                                        </v-row>

                                    </v-img>


                                    <v-btn
                                        color="green darken-4"
                                        text
                                        @click="selectPass"
                                    >Select Passport Photo</v-btn>
                                    <small v-if="imgSizeError" class="red--text align-self-end">Error: Image size should be less than 500kb</small>
                                    <input accept="image/png, image/jpeg, image/bmp" style="display:none" id="filepass" type="file" v-on:change="passChange" >

                                </v-row>
                            </v-container>
                        </v-form>

                    </v-card-text>
                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn color="red darken-1" text @click="editDlg = false">Cancel</v-btn>
                        <v-btn color="green darken-4" text @click="upAccount">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>


        <v-row justify="center">
            <v-dialog v-model="errDlg" max-width="40%">

                <v-card>
                    <v-card-title class="headline red--text">Something is not right</v-card-title>
                    <v-card-text>
                        <h4 color="'red--text">
                            <v-icon color="red--text">warning</v-icon> You are either not connected or you submitted unique information like email, phone number and account number that already exist
                        </h4>
                    </v-card-text>
                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn color="green darken-1" text @click="errDlg = false">OK</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>

        <v-row justify="center">
            <v-dialog v-model="delDlg" max-width="40%">

                <v-card>
                    <v-card-title class="headline red--text">Confirm Delete</v-card-title>
                    <v-card-text>
                        <h4 color="'red--text">
                            <v-icon color="red--text">question</v-icon> Are you sure want to delete this record ?
                        </h4>
                    </v-card-text>
                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn color="red darken-1" text @click="delete_cont(delitem.id)">Delete</v-btn>
                        <v-btn color="green darken-1" text @click="delDlg = false">Cancel</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>

<script>
    export default {

        props: ['id'],
        data() {
            return {
                delDlg:false,
                errDlg:false,
                accountTabs: 'info',
                payTab: 'pay',
                loansTab: 'loans',
                infoTab: 'info',
                purpose: '',
                dentry: '',
                upformValid: '',
                search: "",
                dobmodal: false,
                loading: false,
                notify: true,
                dmodal: false,
                absolute: false,
                UpformValid: false,
                imageLoading: false,
                imgSizeError: false,
                upaccount: {},
                contDlg: false,
                validForm: false,
                purposes: ['Monthly Contribution', 'Training', 'Business'],
                editDlg: false,
                progress: false,
                delitem:{},
                netDlg: false,
                imgsrc: "/images/avatar.png",
                previewURL: "/images/avatar.png",
                headers: [
                    {text: 'Date', value: 'payment_date',},
                    {text: 'Amount', value: 'amount', sortable: false, align: 'center'},
                    {text: 'Category', value: 'purpose'},
                    {text: 'Date Entered', value: 'created_at'},
                    {text: 'Actions', value: 'actions'}
                ],

                zindex: 999,
                light: true,
                balance: 0,
                amount: null,
                amountRules: [
                    v => !!v || 'Amount is required',
                    v => Number(v) > 0 || "amount should be greater than 0"
                ],
                purposeRules: [
                    v => !!v || 'Category is required',
                ],
                dRules: [
                    v => !!v || 'Category is required',
                ],
                contributions: [],
                account: {},

                titles: ['Mr.', 'Miss', 'Mrs', 'Dr.', 'HE', 'Hon'],
                sexList: ['Male', 'Female', 'None'],
                formValid: true,
                passportrules: [
                    value => !value || value.size < 500000 || 'Picture size should be less than 500kb!'
                ],
                fname: '',
                lname: '',
                nameRules: [
                    v => !!v || 'Name is required',
                ],
                sex: '',
                sexRules: [
                    v => !!v || 'Sex is required',
                ],
                hometown: '',
                hometownRules: [
                    v => !!v || 'Hometown is required',
                ],
                dob: '',
                dobRules: [
                    v => !!v || 'dob is required',
                ],
                address: '',
                addressRules: [
                    v => !!v || 'Address is required',
                ],
                phone: '',
                phoneRules: [
                    v => !!v || 'Phone Number is required',

                ],
                bank: '',
                bankRules: [
                    v => !!v || 'Bank Name is required',
                ],
                accno: '',
                accnoRules: [
                    v => !!v || 'A valid account number is required',
                ],
                occupation: '',
                occupationRules: [
                    v => !!v || 'Occupation is required',
                ],
                passport: '',
                email: '',
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid',
                ],
                title: '',
                titleRules: [
                    v => !!v || 'Title is required',
                ],
                newpass:{}

            }

        },
        mounted() {




            this.getaccount();

    },
        methods:{
            delete_cont(id){
                console.log(id);
                this.progress = true;
              fetch('/api/deletecont/'+id,{
                  method: 'DELETE'

              })
                  .then(res=>res.json())
                  .then(res=>{
                      this.progress = false;
                      this.delDlg = false;
                      this.balance = Number(this.balance - Number(res.amount));

                  })
                  .catch(()=>{
                      this.progress = false;

                  })


            },

            delCont(obj){
                //show the delete dialog and set the object for deleting

                this.delDlg = true;
                this.delitem = obj;

            },

            selectPass()
            {
                let pass = document.getElementById('filepass');
                pass.click();
            },

            upAccount(){
               if(this.$refs.UpaccountForm.validate()) {
                   this.progress=true;
                   let upform = new FormData();
                   upform.append('fname', this.upaccount.fname);
                   upform.append('lname', this.upaccount.lname);
                   upform.append('sex', this.upaccount.sex);
                   upform.append('hometown', this.upaccount.hometown);
                   upform.append('dob', this.upaccount.dob);
                   upform.append('address', this.upaccount.address);
                   upform.append('phone', this.upaccount.phone);
                   upform.append('bank', this.upaccount.bank);
                   upform.append('accno', this.upaccount.accno);
                   upform.append('occupation', this.upaccount.occupation);
                   upform.append('email', this.upaccount.email);
                   upform.append('passport', this.newpass);
                   upform.append('title', this.upaccount.title);
                   upform.append('ac_id', this.upaccount.id);

                   fetch("/api/upaccount", {
                       body: upform,
                       method: "POST"
                   })
                       .then(res => res.json())
                       .then(res => {
                           this.account = res;
                           this.progress = false;
                           this.editDlg = false;
                       })
                       .catch(() => {
                           this.progress = false;
                           this.errDlg = true;

                       });


            }
               },


            passChange(e){

                this.imageLoading = true;
                this.newpass = e.target.files[0];
                console.log(this.upaccount.passport);
                if(this.newpass.size<532598){
                    this.imgSizeError = false;
                    const fr = new FileReader();
                    fr.readAsDataURL(this.newpass);
                    fr.onload = ()=>{

                        this.account.passport = fr.result;
                        this.imageLoading=false;
                    }
                }else{

                    this.imgSizeError=true;
                }

            },
            getaccount(){
                this.progress= true;
                this.netDlg = false;
                fetch('/api/account/'+this.id)
                    .then(res=>res.json())
                    .then(res=>{
                        this.progress = false;
                        this.account = res.account;
                        this.contributions = res.conts;
                        this.balance = res.balance;
                        this.upaccount = JSON.parse(JSON.stringify(this.account));
                        console.log(res);
                    }).catch(()=>{

                        this.netDlg=true;
                        this.progress = false;
                });
            },
            addCont(){
                this.contDlg=true;
            },

            saveCont() {
                if (this.$refs.contForm.validate()) {
                    this.progress = true;
                    let formdata = new FormData();
                    formdata.append('ac_id', this.account.id);
                    formdata.append('amount', this.amount);
                    formdata.append('payment_date', this.dentry);
                    formdata.append('purpose', this.purpose);
                    fetch('/api/savecont',{
                        method:'POST',
                        body:formdata
                    })
                        .then(res=>res.json())
                        .then(res=>{
                            this.contributions.push(res);
                            this.progress = false;
                            this.contDlg = false;
                            this.balance+=Number(this.amount);
                        }).catch(()=>{
                            this.progress = false;
                            this.netDlg = true;
                    });

                }

            }
        }

    }

</script>
