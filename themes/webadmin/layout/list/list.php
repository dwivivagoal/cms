                    <p class="text-muted font-13 m-b-30">
                    
                    </p>
					
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>No</th>
                            
                            {FIELDS_LIST}
                            <th>{label}</th>
                            {/FIELDS_LIST}
                            <th>Action</th>
                        </tr>  
                        
                      </thead>
                      <tbody>
                          {DATA_LIST}
                          <tr>
                              <th>{no}</th>
                              {fields}
                              <th>{key}</th>
                              {/fields}
                              <th>{actions}</th>
                          </tr>
                          {/DATA_LIST}
                      </tbody>
                    </table>