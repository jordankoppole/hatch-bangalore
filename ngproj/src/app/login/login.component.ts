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

  private showModal: Boolean = false;
  private modalType: string = 'login'; // register or invite
  private showPasswordError: Boolean = false;
  private showUsernameError: Boolean = false;
  private showAcceptTerms: Boolean = false;

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
    let fields: any = f.value;
    if (fields.pw1 !== fields.pw2) {
      this.showPasswordError = true;
      return;
    }
    if (!fields.terms) {
      this.showAcceptTerms = true;
      return;
    }
    f.reset();
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
