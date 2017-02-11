import { NgForm } from '@angular/forms';
import { Broadcaster } from './../services/broadcaster.service';
import { CommonService } from './../services/common.service';

import {
  Component,
  OnInit
} from '@angular/core';

import { AppState } from '../app.service';

@Component({
  selector: 'login',
  styleUrls: [ './login.component.scss' ],
  templateUrl: './login.component.html'
})
export class LoginComponent implements OnInit {

  private showModal: boolean = false;
  private modalType: string = 'login'; // register or invite
  private showPasswordError: boolean = false;
  private showUsernameError: boolean = false;
  private showAcceptTerms: boolean = false;
  private registerFormDisabled: boolean = false;

  constructor(
    public appState: AppState,
    private commonService: CommonService,
    private broadcaster: Broadcaster
  ) {}

  public ngOnInit() {
    // yet to be written
    this.listenToEvents();
  }

  public closeModal() {
    this.showModal = false;
  }

  public switchTo(modalType: string) {
    this.modalType = modalType;
  }

  public onSubmit(f: NgForm) {
    // console.log(f.value);  // { first: '', last: '' }
    // console.log(f.valid);  // false
    this.registerFormDisabled = true;
    let fields: any = f.value;
    if (fields.pw1 !== fields.pw2) {
      this.showPasswordError = true;
      return;
    }
    if (!fields.terms) {
      this.showAcceptTerms = true;
      return;
    }
    const md5 = require('js-md5');
    let params = {
      firstname: fields.userFirstName,
      lastname: fields.userLastName,
      username: fields.userName,
      email: fields.userEmail,
      password: md5(fields.pw1),
    };
    this.commonService.createUser(params)
      .then((resp) => {
        this.registerFormDisabled = false;
        console.log(resp);
        if (resp.status !== 200) {
          this.showUsernameError = true;
        } else {
          f.reset();
          this.resetErrors();
          this.modalType = 'login';
        }
      });
  }

  private resetErrors() {
    this.showPasswordError = false;
    this.showUsernameError = false;
    this.showAcceptTerms = false;
  }

  private listenToEvents() {
    this.broadcaster.on<string>('login_modal')
      .subscribe((message) => {
        if (message === 'open') {
          this.showModal = true;
        }
      });
  }

}
