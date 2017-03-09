import { NgForm } from '@angular/forms';
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

  public errorMessage: string = '';
  public professionalTitleError: boolean = false;
  public statementErrorMsg: boolean = false;
  public places: any[] = [{"id":"1","name":"India","code":"IN","states":[{"id":"1","name":"Karnataka","country_id":"1","code":"KA","cities":[{"id":"1","name":"Bangalore","state_id":"1","code":"BLR"}]},{"id":"2","name":"West bengal","country_id":"1","code":"WB","cities":[{"id":"2","name":"Kolkata","state_id":"2","code":"KOL"}]}]},{"id":"2","name":"United States","code":"US","states":[{"id":"3","name":"North Carolina","country_id":"2","code":"NC","cities":[{"id":"3","name":"Charlotte","state_id":"3","code":"CLT"}]},{"id":"4","name":"Minnesota","country_id":"2","code":"MN","cities":[{"id":"4","name":"Minneapolis","state_id":"4","code":"MN"}]}]}];
  public states: any[] = [];

  @Input() private showModal: boolean = false;
  @Input() private profile;

  constructor(
    private commonService: CommonService,
    private broadcaster: Broadcaster
  ) {}

  public ngOnInit() {
    console.log(this.profile);
    this.getPlaces();
    // Init function
  }

  public openModal() {
    this.showModal = true;
  }

  public closeModal() {
    this.showModal = false;
  }

  public getPlaces() {
    this.commonService.getPlaces().then((places) => {
      console.log('Places fetched', JSON.stringify(places));
      this.places = places;
    });
  }

  public onCountryChange(id) {
    this.states = [{"id":"1","name":"Karnataka","country_id":"1","code":"KA","cities":[{"id":"1","name":"Bangalore","state_id":"1","code":"BLR"}]},{"id":"2","name":"West bengal","country_id":"1","code":"WB","cities":[{"id":"2","name":"Kolkata","state_id":"2","code":"KOL"}]}];
  }

  public onProfileSubmit(f: NgForm) {
    console.log(f.value);
  }

}
