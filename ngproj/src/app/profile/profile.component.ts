import { Broadcaster } from './../services/broadcaster.service';
import { CommonService } from './../services/common.service';
import {
  Component,
  OnInit
} from '@angular/core';

// import { XLargeDirective } from './x-large';

@Component({
  selector: 'profile',  // <profile></profile>
  // Our list of styles in our component. We may add more to compose many styles together
  styleUrls: [ './profile.component.css' ],
  // Every Angular template is first compiled by the browser before Angular runs it's compiler
  templateUrl: './profile.component.html'
})
export class ProfileComponent implements OnInit {

  public events: any[] = [];
  public commUsers: any[] = [];

  constructor(
    private commonService: CommonService,
    private broadcaster: Broadcaster
  ) {}

  public ngOnInit() {
    // Init function
  }
}
