export default class Gate{

   constructor(user){
    this.user = user;
   }

   isAdmin(){
       return this.user.type === 'admin';
   }

   isEmployee(){
        return this.user.type === 'employee';
    }

    isTech(){
        return this.user.type === 'tech';
    }
}
