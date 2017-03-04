import { Broadcaster } from './../../services/broadcaster.service';
import { CommonService } from './../../services/common.service';
import {
  Component,
  OnInit,
  Input
} from '@angular/core';

// import { XLargeDirective } from './x-large';

@Component({
  selector: 'profile-create',  // <profile-create></profile-create>
  // Our list of styles in our component. We may add more to compose many styles together
  styleUrls: [ './profile-create.component.scss' ],
  // Every Angular template is first compiled by the browser before Angular runs it's compiler
  templateUrl: './profile-create.component.html'
})
export class ProfileCreateComponent implements OnInit {

  public events: any[] = [];
  public commUsers: any[] = [];

  @Input() private showModal: boolean = false;

  constructor(
    private commonService: CommonService,
    private broadcaster: Broadcaster
  ) {}

  public ngOnInit() {
    // Init function
  }

  public openModal() {
    this.showModal = true;
  }

  public closeModal() {
    this.showModal = false;
  }

}
